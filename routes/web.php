<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\MathProblemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/games', function() {
    return view('mathgames/mathgames');
});


Route::get('/select-topic', [MathProblemController::class, 'selectTopic']); // Topic selection page
Route::post('/start-test', [MathProblemController::class, 'startTest']); // Quiz page


Route::get('/math-problems', function () {
    return view('math_problems');
});

Route::get('/math-problems', [MathProblemController::class, 'index']); // Front-end view
Route::post('/generate-math-problem', [MathProblemController::class, 'generate']); // API to generate problems
Route::get('/math-problems/{grade}/{topic}', [MathProblemController::class, 'getProblems']); // Fetch problems

Route::post('/submit-answers', [QuestionController::class, 'submitAnswers']);


Route::post('/questions/generate', [QuestionController::class, 'generate']);
Route::get('/questions/{grade}', [QuestionController::class, 'getQuestions']);


Route::post('/generate-math-problem', function (Request $request, OpenAIService $openAIService) {
    $request->validate([
        'grade_level' => 'required|string',
        'topic' => 'required|string',
    ]);

    $problemData = $openAIService->generateMathProblem($request->grade_level, $request->topic);

    if ($problemData) {
        $problem = MathProblem::create([
            'grade_level' => $request->grade_level,
            'topic' => $request->topic,
            'question' => $problemData['question'],
            'answers' => $problemData['answers'],
            'correct_answer' => $problemData['correct_answer']
        ]);

        return response()->json($problem, 201);
    }

    return response()->json(['error' => 'Failed to generate problem'], 500);
});
