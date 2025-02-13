<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MathProblem;
use App\Services\OpenAIService;

class MathProblemController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    // Display the front-end view
    public function index()
    {
        return view('math_problems');
    }

    // Generate and store a new math problem
    public function generate(Request $request)
    {
        $request->validate([
            'grade_level' => 'required|string',
            'topic' => 'required|string',
        ]);

        $problemData = $this->openAIService->generateMathProblem($request->grade_level, $request->topic);

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
    }

    // Fetch stored problems by grade and topic
    public function getProblems($grade, $topic)
    {
        $problems = MathProblem::where('grade_level', $grade)
            ->where('topic', $topic)
            ->get();

        return response()->json($problems);
    }



     // Display the topic selection page
     public function selectTopic()
     {
         $grades = MathProblem::select('grade_level')->distinct()->pluck('grade_level');
         $topics = MathProblem::select('topic')->distinct()->pluck('topic');
 
         return view('select_topic', compact('grades', 'topics'));
     }
 
     // Fetch questions for a selected topic
     public function startTest(Request $request)
{
    $request->validate([
        'grade_level' => 'required|string',
        'topic' => 'required|string',
    ]);

    $questions = MathProblem::where('grade_level', $request->grade_level)
        ->where('topic', $request->topic)
        ->inRandomOrder()
        ->take(10)
        ->get()
        ->map(function ($question) {
            return [
                'question' => $question->question,
                'answers' => json_decode($question->answers, true), // Decode JSON in backend
                'correct_answer' => $question->correct_answer
            ];
        });

    return view('quiz', compact('questions', 'request'));
}

}
