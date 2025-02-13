<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Problem Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 p-6 flex justify-center items-center h-screen">

    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg" x-data="mathProblemApp()">
        <h2 class="text-2xl font-bold mb-4 text-center">Generate Math Problems</h2>

        <!-- Select Grade -->
        <label class="block text-gray-700 font-medium">Select Grade:</label>
        <select x-model="grade" class="w-full p-2 border rounded mt-1">
            <option value="">Choose a Grade</option>
            <option value="6th">6th</option>
            <option value="7th">7th</option>
            <option value="8th">8th</option>
            <option value="9th">9th</option>
            <option value="10th">10th</option>
        </select>

        <!-- Select Topic -->
        <label class="block text-gray-700 font-medium mt-4">Select Topic:</label>
        <select x-model="topic" class="w-full p-2 border rounded mt-1">
            <option value="">Choose a Topic</option>
            <option value="Algebra">Algebra</option>
            <option value="Geometry">Geometry</option>
            <option value="Fractions">Fractions</option>
            <option value="Probability">Probability</option>
            <option value="Trigonometry">Trigonometry</option>
        </select>

        <!-- Generate Button -->
        <button 
            @click="fetchMathProblem()" 
            class="bg-blue-500 text-white w-full p-2 mt-4 rounded hover:bg-blue-600"
            :disabled="!grade || !topic"
        >
            Generate Math Problem
        </button>

        <!-- Display Question -->
        <div x-show="question" class="mt-6">
            <h3 class="text-lg font-semibold">Question:</h3>
            <p class="text-gray-800 mt-2" x-text="question"></p>

            <!-- Multiple Choice Answers -->
            <div class="mt-4">
                <template x-for="(answer, index) in answers" :key="index">
                    <button 
                        @click="checkAnswer(answer)" 
                        class="block w-full text-left p-2 border rounded mt-1"
                        :class="{'bg-green-200': answer === correctAnswer && answered, 'bg-red-200': answer !== correctAnswer && answered}"
                    >
                        <span x-text="answer"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Feedback -->
        <div x-show="answered" class="mt-4">
            <p x-text="feedback" class="text-lg font-bold" :class="correctAnswer === selectedAnswer ? 'text-green-600' : 'text-red-600'"></p>
        </div>
    </div>

    <script>
        function mathProblemApp() {
            return {
                grade: '',
                topic: '',
                question: '',
                answers: [],
                correctAnswer: '',
                selectedAnswer: '',
                answered: false,
                feedback: '',
                
                async fetchMathProblem() {
                    this.answered = false;
                    this.feedback = '';

                    const response = await fetch('/generate-math-problem', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ grade_level: this.grade, topic: this.topic })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        this.question = data.question;
                        this.answers = JSON.parse(data.answers);
                        this.correctAnswer = data.correct_answer;
                    } else {
                        alert('Failed to generate math problem');
                    }
                },

                checkAnswer(answer) {
                    this.selectedAnswer = answer;
                    this.answered = true;
                    this.feedback = answer === this.correctAnswer ? 'Correct!' : 'Incorrect. Try again!';
                }
            };
        }
    </script>

</body>
</html>
