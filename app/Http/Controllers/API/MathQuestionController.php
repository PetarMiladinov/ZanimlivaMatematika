<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ChatGPTService;
use Illuminate\Http\JsonResponse;



class MathQuestionController extends Controller
{
    protected $chatGPTService;

    public function __construct(ChatGPTService $chatGPTService)
    {
        $this->chatGPTService = $chatGPTService;
    }

    public function generate($grade, $topic): JsonResponse
    {
        $data = $this->chatGPTService->generateQuestion($topic, $grade);

        if (!$data || !isset($data['question'])) {
            return response()->json(['error' => 'Failed to generate question'], 500);
        }

        return response()->json($data);
    }
}
