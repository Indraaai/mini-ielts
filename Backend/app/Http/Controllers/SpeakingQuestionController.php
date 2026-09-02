<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\SpeakingQuestionService;
use OpenApi\Attributes as OA;

class SpeakingQuestionController extends Controller
{
    public function __construct(private SpeakingQuestionService $speakingQuestionService) {}


    #[OA\Get(
        path: '/api/speaking/questions',
        summary: 'Get speaking questions',
        tags: ['Speaking Questions'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of speaking questions',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(
                                        property: 'id',
                                        type: 'integer',
                                        example: 1
                                    ),
                                    new OA\Property(
                                        property: 'part',
                                        type: 'string',
                                        example: 'Part 1'
                                    ),
                                    new OA\Property(
                                        property: 'topic',
                                        type: 'string',
                                        example: 'Education'
                                    ),
                                    new OA\Property(
                                        property: 'prompt',
                                        type: 'string',
                                        example: 'Do you enjoy studying?'
                                    ),
                                ]
                            )
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $questions = $this->speakingQuestionService->getAllQuestions();

        return response()->json([
            'data' => $questions,
        ]);
    }
}
