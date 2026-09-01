<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\SpeakingQuestionService;

class SpeakingQuestionController extends Controller
{
    public function __construct(private SpeakingQuestionService $speakingQuestionService) {}
    
    public function index(): JsonResponse
{
    $questions = $this->speakingQuestionService->getAllQuestions();

    return response()->json([
        'data' => $questions,
    ]);
}
}
