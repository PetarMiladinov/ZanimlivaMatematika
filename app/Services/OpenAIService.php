<?php

namespace App\Services;

use OpenAI;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
    }

    public function generateMathProblem($grade, $topic)
    {
        $prompt = "Generate a JSON object for a $grade grade math problem in the topic of $topic. 
        The object should contain:
        - a 'question' field with the math problem
        - an 'answers' array with 4 multiple-choice answers
        - a 'correct_answer' field indicating the correct choice.
        
        Example:
        {
            \"question\": \"What is 5 + 7?\",
            \"answers\": [\"10\", \"11\", \"12\", \"13\"],
            \"correct_answer\": \"12\"
        }";

        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [['role' => 'system', 'content' => $prompt]],
            'max_tokens' => 100
        ]);

        

        return json_decode($response->choices[0]->message->content, true);
    }
}
