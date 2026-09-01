<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {
    }

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

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    public function logout(Request $request): JsonResponse
{
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logout successful',
    ]);
}
}