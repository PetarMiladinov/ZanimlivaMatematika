<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MathQuestionController;

Route::prefix('v1')->group(function () {
    Route::get('/questions/{grade}/{topic}', [MathQuestionController::class, 'generate']);
});