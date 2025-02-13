<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fiilable = ['title', 'grade', 'question', 'answers', 'correct_answer', 'solve_count'];

    protected $casts = [
        'answers' => 'array',
    ];
}
