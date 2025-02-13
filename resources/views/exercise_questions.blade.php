@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Math Quiz</h1>
    <form id="quizForm">
        @csrf
        <div id="questionContainer">
            @foreach ($questions as $question)
                <div class="question-card">
                    <p class="font-weight-bold">{{ $question->question }}</p>
                    @foreach (json_decode($question->answers) as $answer)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->text }}" required>
                            <label class="form-check-label">{{ $answer->text }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary mt-3">Submit Answers</button>
    </form>

    <div id="results" class="mt-4 d-none">
        <h3>Your Results</h3>
        <p><strong>Accuracy:</strong> <span id="accuracy"></span>%</p>
        <h4>Mistakes:</h4>
        <ul id="mistakes"></ul>
        <button class="btn btn-success mt-2" onclick="window.location.reload()">Try Again</button>
        <a href="/exercises/{{ $grade }}" class="btn btn-info mt-2">Choose Another Topic</a>
    </div>
</div>

<script>
document.getElementById('quizForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let formData = {
        _token: document.querySelector('input[name=_token]').value,
        answers: []
    };

    document.querySelectorAll('input[type=radio]:checked').forEach(input => {
        formData.answers.push({
            question_id: input.name.replace('answers[', '').replace(']', ''),
            selected_answer: input.value
        });
    });

    fetch('/api/submit-answers', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('questionContainer').classList.add('d-none');
        document.getElementById('results').classList.remove('d-none');
        document.getElementById('accuracy').innerText = data.accuracy.toFixed(2);

        let mistakeList = document.getElementById('mistakes');
        mistakeList.innerHTML = "";
        data.mistakes.forEach(mistake => {
            mistakeList.innerHTML += `<li><b>Question:</b> ${mistake.question}<br>
                                      <b>Your Answer:</b> ${mistake.your_answer}<br>
                                      <b>Correct Answer:</b> ${mistake.correct_answer}</li>`;
        });
    });
});
</script>
@endsection
