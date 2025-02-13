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

    public function getTopicsByGrade($grade)
    {
        $topics = Question::where('grade', $grade)->distinct()->pluck('title');
        return response()->json($topics);
    }

    public function getQuestionsByTopic($grade, $title)
    {
        $questions = Question::where('grade', $grade)->where('title', $title)->limit(10)->get();
        return response()->json($questions);
    }

    public function submitAnswers(Request $request)
{
    $request->validate([
        'answers' => 'required|array',
        'answers.*.question_id' => 'required|exists:questions,id',
        'answers.*.selected_answer' => 'required|string'
    ]);

    $correct = 0;
    $mistakes = [];

    foreach ($request->answers as $answer) {
        $question = Question::find($answer['question_id']);
        $is_correct = $question->correct_answer == $answer['selected_answer'];

        // Store attempt in the user_attempts table
        UserAttempt::create([
            'user_id' => auth()->id(), // Null if guest user
            'question_id' => $question->id,
            'selected_answer' => $answer['selected_answer'],
            'is_correct' => $is_correct
        ]);

        if ($is_correct) {
            $correct++;
        } else {
            $mistakes[] = [
                'question' => $question->question,
                'your_answer' => $answer['selected_answer'],
                'correct_answer' => $question->correct_answer
            ];
        }

        // Increment solve count
        $question->increment('solve_count');

        // Regenerate if question reaches 10,000 solves
        if ($question->solve_count >= 10000) {
            $data = $this->chatGPTService->generateQuestion($question->title, $question->grade);
            $question->update([
                'question' => $data['question'],
                'answers' => json_encode($data['answers']),
                'correct_answer' => $data['correct_answer'],
                'solve_count' => 0
            ]);
        }
    }

    return response()->json([
        'accuracy' => ($correct / count($request->answers)) * 100,
        'mistakes' => $mistakes
    ]);
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
