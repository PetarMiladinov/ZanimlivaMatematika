<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg" x-data="quizApp()">
        <h2 class="text-2xl font-bold mb-4 text-center">Math Quiz - {{ $request->grade_level }} ({{ $request->topic }})</h2>

        <template x-if="currentQuestionIndex < questions.length">
            <div>
                <h3 class="text-lg font-semibold mb-2" x-text="questions[currentQuestionIndex].question"></h3>

                <div class="mt-4">
                    <template x-for="(answer, index) in questions[currentQuestionIndex].answers" :key="index">
                        <button 
                            @click="checkAnswer(answer)" 
                            class="block w-full text-left p-2 border rounded mt-1"
                            :class="{
                                'bg-green-200': answer === questions[currentQuestionIndex].correct_answer && answered,
                                'bg-red-200': answer !== questions[currentQuestionIndex].correct_answer && answered
                            }"
                        >
                            <span x-text="answer"></span>
                        </button>
                    </template>
                </div>

                <div x-show="answered" class="mt-4">
                    <p x-text="feedback" class="text-lg font-bold" :class="correctAnswer === selectedAnswer ? 'text-green-600' : 'text-red-600'"></p>
                    <button @click="nextQuestion()" class="mt-4 bg-blue-500 text-white w-full p-2 rounded hover:bg-blue-600">
                        Next Question
                    </button>
                </div>
            </div>
        </template>

        <div x-show="currentQuestionIndex >= questions.length" class="text-center">
            <h3 class="text-xl font-bold">Quiz Complete!</h3>
            <p class="mt-2">You answered <span x-text="score"></span> / 10 correctly!</p>
            <a href="/select-topic" class="mt-4 block bg-green-500 text-white p-2 rounded hover:bg-green-600">
                Choose Another Topic
            </a>
        </div>
    </div>

    <script>
        function quizApp() {
            return {
                questions: @json($questions), // Directly passing decoded questions from Laravel
                currentQuestionIndex: 0,
                selectedAnswer: '',
                answered: false,
                feedback: '',
                score: 0,

                checkAnswer(answer) {
                    this.selectedAnswer = answer;
                    this.answered = true;
                    let correct = this.questions[this.currentQuestionIndex].correct_answer;
                    if (answer === correct) {
                        this.feedback = 'Correct!';
                        this.score++;
                    } else {
                        this.feedback = 'Incorrect. Try again!';
                    }
                },

                nextQuestion() {
                    this.answered = false;
                    this.feedback = '';
                    this.currentQuestionIndex++;
                }
            };
        }
    </script>

</body>
</html>
