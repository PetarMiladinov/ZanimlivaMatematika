<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ChatGPTService;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class GenerateQuestions extends Command
{
    protected $signature = 'questions:generate';
    protected $description = 'Automatically generate math questions for each grade and topic';
    protected $chatGPTService;
    protected $topics = ['Algebra', 'Geometry', 'Probability', 'Fractions', 'Equations'];


    public function __construct(ChatGPTService $chatGPTService){
        parent::__construct();
        $this->ChatGPTService=$chatGPTService;
}

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (range(6, 10) as $grade) {
            foreach ($this->topics as $title) {
                $data = $this->chatGPTService->generateQuestion($title, $grade);

                if (!$data || !isset($data['question'])) {
                    $this->error("Failed to generate question for $title (Grade $grade)");
                    continue;
                }

                Question::create([
                    'title' => $title,
                    'grade' => $grade,
                    'question' => $data['question'],
                    'answers' => json_encode($data['answers']),
                    'correct_answer' => $data['correct_answer']
                ]);

                $this->info("Question added: $title (Grade $grade)");
            }
        }
    }
}
