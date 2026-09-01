<?php

use App\Exceptions\GeminiException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn() => null);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (
            GeminiException $_e,
            Request $request
        ) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Speaking evaluation service is temporarily unavailable.',
                ], 503);
            }
        });
    })
    ->create();
