<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    #[OA\Post(
        path: '/api/auth/register',
        summary: 'Register a new user',
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: [
                    'name',
                    'email',
                    'password',
                    'password_confirmation',
                ],
                properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        example: 'Indra Firmansyah'
                    ),
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        format: 'email',
                        example: 'indra@example.com'
                    ),
                    new OA\Property(
                        property: 'password',
                        type: 'string',
                        format: 'password',
                        example: 'password123'
                    ),
                    new OA\Property(
                        property: 'password_confirmation',
                        type: 'string',
                        format: 'password',
                        example: 'password123'
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'User registered successfully'
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            ),
        ]
    )]
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register(
            $request->validated()
        );

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
        ], 201);
    }

    #[OA\Post(
        path: '/api/auth/login',
        summary: 'Login user',
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        format: 'email',
                        example: 'user@example.com'
                    ),
                    new OA\Property(
                        property: 'password',
                        type: 'string',
                        format: 'password',
                        example: 'password123'
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Login successful'
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            ),
        ]
    )]

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->authService->login(
            $request->validated()
        );

        return response()->json([
            'message' => 'Login successful',
            'token' => $data['token'],
            'user' => $data['user'],
        ]);
    }

    #[OA\Get(
        path: '/api/auth/me',
        summary: 'Get authenticated user',
        tags: ['Authentication'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Authenticated user'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
        ]
    )]
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    #[OA\Post(
        path: '/api/auth/logout',
        summary: 'Logout authenticated user',
        tags: ['Authentication'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Logout successful'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
        ]
    )]
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful',
        ]);
    }
}
