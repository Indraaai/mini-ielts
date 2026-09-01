<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpeakingQuestionController;
use App\Http\Controllers\SpeakingAttemptController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('speaking/questions', SpeakingQuestionController::class);

// auth
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::post(
        '/speaking/submit',
        [SpeakingAttemptController::class, 'submit']
    );
    Route::get(
        '/speaking/attempts',
        [SpeakingAttemptController::class, 'index']
    );
    Route::get(
        '/speaking/attempts/{attemptId}',
        [SpeakingAttemptController::class, 'show']
    );
});
