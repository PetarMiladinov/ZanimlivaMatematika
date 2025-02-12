<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ChatGPTService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function generateQuestion($topic, $grade)
    {
        // Simulate AI response
        return [
            'question' => "What is 2 + 2 in the context of $topic for grade $grade?",
            'answers' => [4, 3, 5, 6],
            'correct' => 4
        ];
    }

    public function register()
{
    $this->app->singleton(ChatGPTService::class, function ($app) {
        return new ChatGPTService();
    });
}

    // public function generateQuestion($title, $grade)
    // {
    //     $prompt = "Generate a multiple-choice math question for a $grade-grade student on the topic '$title'.
    //     Return a JSON object with 'question', 'answers' (array), and 'correct_answer'.";

    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . $this->apiKey,
    //         'Content-Type' => 'application/json'
    //     ])->post('https://api.openai.com/v1/chat/completions', [
    //         'model' => 'gpt-4',
    //         'messages' => [
    //             ['role' => 'system', 'content' => 'You are an expert math question generator.'],
    //             ['role' => 'user', 'content' => $prompt]
    //         ],
    //         'max_tokens' => 200
    //     ]);

    //     return json_decode($response->body(), true);
    // }
}
