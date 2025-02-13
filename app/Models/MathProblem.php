<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MathProblem extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_level',
        'topic',
        'question',
        'answers',
        'correct_answer',
        'solve_count'
    ];

    protected $casts = [
        'answers' => 'array', // Automatically convert JSON to an array
    ];
}