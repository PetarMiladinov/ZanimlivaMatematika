<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected $chatGPTService;

    public function __construct(ChatGPTService $chatGPTService)
    {
        $this->chatGPTService = $chatGPTService;
    }

    public function generate(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'grade' => 'required|integer|min:6|max:10',
        ]);

        $data = $this->chatGPTService->generateQuestion($request->title, $request->grade);
        if (!$data || !isset($data['question'])) {
            return response()->json(['error' => 'Failed to generate question'], 500);
        }

        $question = Question::create([
            'title' => $request->title,
            'grade' => $request->grade,
            'question' => $data['question'],
            'answers' => json_encode($data['answers']),
            'correct_answer' => $data['correct_answer']
        ]);

        return response()->json($question, 201);

    }



    public function getQuestions($grade)
    {
        $questions = Question::where('grade', $grade)->get();
        return response()->json($questions);
    }
}
