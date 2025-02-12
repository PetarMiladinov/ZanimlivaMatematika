<?php

use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/games', function() {
    return view('mathgames');
});


Route::post('/questions/generate', [QuestionController::class, 'generate']);
Route::get('/questions/{grade}', [QuestionController::class, 'getQuestions']);