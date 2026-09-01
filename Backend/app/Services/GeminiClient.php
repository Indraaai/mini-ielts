<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;
use App\Exceptions\GeminiException;

class GeminiClient
{
    public function generate(
        string $prompt,
        array $responseSchema
    ): array {
        $response = Http::withHeaders([
            'x-goog-api-key' => config('services.gemini.api_key'),
            'Content-Type' => 'application/json',
        ])
            ->timeout(60)
            ->retry(2, 1000)
            ->post(
                'https://generativelanguage.googleapis.com/v1beta/interactions',
                [
                    'model' => config('services.gemini.model'),
                    'input' => $prompt,
                    'response_format' => [
                        'type' => 'text',
                        'mime_type' => 'application/json',
                        'schema' => $responseSchema,
                    ],
                ]
            );

        if ($response->failed()) {
            throw new GeminiException(
                'Gemini API request failed.'
            );
        }

        $steps = $response->json('steps', []);

        foreach ($steps as $step) {
            if (($step['type'] ?? null) !== 'model_output') {
                continue;
            }

            foreach ($step['content'] ?? [] as $content) {
                if (($content['type'] ?? null) !== 'text') {
                    continue;
                }

                $text = $content['text'] ?? null;

                if (! is_string($text) || $text === '') {
                    continue;
                }

                $decoded = json_decode($text, true);

                if (! is_array($decoded)) {
                    throw new GeminiException(
                        'Gemini API returned invalid JSON.'
                    );
                }

                return $decoded;
            }
        }

        throw new GeminiException(
            'Gemini API returned no usable model output.'
        );
    }
}
