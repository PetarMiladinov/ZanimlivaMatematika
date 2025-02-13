<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Services\OpenAIService;
use App\Models\MathProblem;

class MathProblemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $openAIService = new OpenAIService();

        $grades = ['6th', '7th', '8th', '9th', '10th'];
        $topics = ['Algebra', 'Geometry', 'Fractions', 'Probability', 'Trigonometry'];

        foreach ($grades as $grade) {
            foreach ($topics as $topic) {
                $problemData = $openAIService->generateMathProblem($grade, $topic);

                if ($problemData) {
                    MathProblem::create([
                        'grade_level' => $grade,
                        'topic' => $topic,
                        'question' => $problemData['question'],
                        'answers' => json_encode($problemData['answers']),
                        'correct_answer' => $problemData['correct_answer']
                    ]);
                }
            }
        }
    }
}
