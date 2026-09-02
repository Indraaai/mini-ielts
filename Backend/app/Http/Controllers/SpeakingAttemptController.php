<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitSpeakingAttemptRequest;
use App\Http\Resources\SpeakingAttemptResource;
use App\Services\SpeakingAttemptService;
use App\Services\SpeakingEvaluationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class SpeakingAttemptController extends Controller
{
    public function __construct(
        private SpeakingAttemptService $speakingAttemptService,
        private SpeakingEvaluationService $speakingEvaluationService
    ) {}

    #[OA\Get(
        path: '/api/speaking/attempts',
        summary: 'Get speaking attempt history',
        description: 'Get all speaking attempts belonging to the authenticated user.',
        tags: ['Speaking'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of speaking attempts'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $attempts = $this->speakingAttemptService->getByUserId(
            $request->user()->id
        );

        return response()->json([
            'data' => SpeakingAttemptResource::collection($attempts),
        ]);
    }


    #[OA\Post(
        path: '/api/speaking/submit',
        summary: 'Submit and evaluate a speaking answer',
        description: 'Submit a speaking answer for AI evaluation.',
        tags: ['Speaking'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['question_id', 'answer'],
                properties: [
                    new OA\Property(
                        property: 'question_id',
                        type: 'integer',
                        example: 1
                    ),
                    new OA\Property(
                        property: 'answer',
                        type: 'string',
                        example: 'I really enjoy studying computer science because it allows me to solve problems and build useful applications.'
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Speaking answer evaluated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Speaking answer evaluated successfully'
                        ),
                        new OA\Property(
                            property: 'data',
                            properties: [
                                new OA\Property(
                                    property: 'attempt',
                                    properties: [
                                        new OA\Property(
                                            property: 'id',
                                            type: 'integer',
                                            example: 2
                                        ),
                                        new OA\Property(
                                            property: 'question_id',
                                            type: 'integer',
                                            example: 1
                                        ),
                                        new OA\Property(
                                            property: 'answer',
                                            type: 'string',
                                            example: 'I really enjoy studying computer science because it allows me to solve problems and build useful applications.'
                                        ),
                                        new OA\Property(
                                            property: 'submitted_at',
                                            type: 'string',
                                            format: 'date-time',
                                            example: '2026-09-01T14:37:44.000000Z'
                                        ),
                                    ],
                                    type: 'object'
                                ),
                                new OA\Property(
                                    property: 'result',
                                    properties: [
                                        new OA\Property(
                                            property: 'id',
                                            type: 'integer',
                                            example: 3
                                        ),
                                        new OA\Property(
                                            property: 'attempt_id',
                                            type: 'integer',
                                            example: 2
                                        ),
                                        new OA\Property(
                                            property: 'estimated_band',
                                            type: 'number',
                                            format: 'float',
                                            example: 6.5
                                        ),
                                        new OA\Property(
                                            property: 'strengths',
                                            type: 'array',
                                            items: new OA\Items(
                                                type: 'string'
                                            ),
                                            example: [
                                                'Directly answers the prompt with a clear and coherent main idea.',
                                                'Uses accurate, context-appropriate vocabulary.'
                                            ]
                                        ),
                                        new OA\Property(
                                            property: 'areas_to_improve',
                                            type: 'array',
                                            items: new OA\Items(
                                                type: 'string'
                                            ),
                                            example: [
                                                'Extend the response with further details or examples.',
                                                'Use a broader variety of grammatical structures.'
                                            ]
                                        ),
                                        new OA\Property(
                                            property: 'feedback',
                                            type: 'string',
                                            example: 'Your answer is clear, accurate, and uses topic-relevant language effectively.'
                                        ),
                                    ],
                                    type: 'object'
                                ),
                            ],
                            type: 'object'
                        ),
                    ],
                    type: 'object'
                )
            ),
        ]
    )]
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


    #[OA\Get(
        path: '/api/speaking/attempts/{attemptId}',
        summary: 'Get speaking attempt detail',
        description: 'Get a specific speaking attempt and its evaluation result belonging to the authenticated user.',
        tags: ['Speaking'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'attemptId',
                description: 'ID of the speaking attempt',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Speaking attempt detail'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
            new OA\Response(
                response: 404,
                description: 'Speaking attempt not found'
            ),
        ]
    )]
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
