<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitSpeakingAttemptRequest;
use App\Http\Resources\SpeakingAttemptResource;
use App\Services\SpeakingAttemptService;
use App\Services\SpeakingEvaluationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpeakingAttemptController extends Controller
{
    public function __construct(
        private SpeakingAttemptService $speakingAttemptService,
        private SpeakingEvaluationService $speakingEvaluationService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $attempts = $this->speakingAttemptService->getByUserId(
            $request->user()->id
        );

        return response()->json([
            'data' => SpeakingAttemptResource::collection($attempts),
        ]);
    }

    public function submit(
        SubmitSpeakingAttemptRequest $request
    ): JsonResponse {
        $result = $this->speakingEvaluationService->submit(
            $request->user()->id,
            $request->validated()
        );

        return response()->json([
            'message' => 'Speaking answer evaluated successfully',
            'data' => [
                'attempt' => new SpeakingAttemptResource(
                    $result['attempt']
                ),
                'result' => $result['result'],
            ],
        ], 201);
    }

    public function show(
        Request $request,
        int $attemptId
    ): JsonResponse {
        $attempt = $this->speakingAttemptService->getByIdAndUserId(
            $attemptId,
            $request->user()->id
        );

        if (! $attempt) {
            return response()->json([
                'message' => 'Speaking attempt not found',
            ], 404);
        }

        return response()->json([
            'data' => new SpeakingAttemptResource($attempt),
        ]);
    }
}
