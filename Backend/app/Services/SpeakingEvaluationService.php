<?php

namespace App\Services;

use App\Models\SpeakingAttempt;
use App\Models\SpeakingResult;
use App\Repositories\SpeakingResultRepository;
use App\Repositories\SpeakingAttemptRepository;
use Illuminate\Support\Facades\DB;


class SpeakingEvaluationService
{
    public function __construct(
        private SpeakingResultRepository $speakingResultRepository,
        private SpeakingAttemptRepository $speakingAttemptRepository,
        private GeminiClient $geminiClient
    ) {}

    public function createResult(
        SpeakingAttempt $attempt,
        array $evaluation
    ): SpeakingResult {
        return $this->speakingResultRepository->create([
            'attempt_id' => $attempt->id,
            'estimated_band' => $evaluation['estimated_band'],
            'strengths' => $evaluation['strengths'],
            'areas_to_improve' => $evaluation['areas_to_improve'],
            'feedback' => $evaluation['feedback'] ?? null,
        ]);
    }
    public function evaluate(SpeakingAttempt $attempt): array
    {
        $prompt = $this->buildPrompt($attempt);

        $schema = [
            'type' => 'object',
            'properties' => [
                'estimated_band' => [
                    'type' => 'number',
                ],
                'strengths' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                ],
                'areas_to_improve' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                ],
                'feedback' => [
                    'type' => 'string',
                ],
            ],
            'required' => [
                'estimated_band',
                'strengths',
                'areas_to_improve',
                'feedback',
            ],
        ];

        return $this->geminiClient->generate(
            $prompt,
            $schema
        );
    }

    public function submit(
        int $userId,
        array $data
    ): array {
        return DB::transaction(function () use ($userId, $data) {
            $attempt = $this->speakingAttemptRepository->create([
                'user_id' => $userId,
                'question_id' => $data['question_id'],
                'answer' => $data['answer'],
                'submitted_at' => now(),
            ]);

            $attempt->load('question');

            $evaluation = $this->evaluate($attempt);

            $result = $this->createResult(
                $attempt,
                $evaluation
            );

            return [
                'attempt' => $attempt,
                'result' => $result,
            ];
        });
    }

    private function buildPrompt(SpeakingAttempt $attempt): string
    {
        return <<<PROMPT
    You are an IELTS Speaking evaluator.

    Evaluate the candidate's answer based on the provided speaking question.

    Speaking question:
    {$attempt->question->prompt}

    Candidate answer:
    {$attempt->answer}

    Evaluate the answer using IELTS Speaking principles, including:
    - Fluency and coherence
    - Lexical resource
    - Grammatical range and accuracy
    - Pronunciation, only to the extent that it can be inferred from the text

    Important:
    - This is a text-based evaluation, so do not claim to accurately assess pronunciation.
    - Provide an estimated IELTS Speaking band score.
    - Keep the feedback concise and constructive.
    - Identify specific strengths.
    - Identify specific areas for improvement.
    - Do not invent information that is not present in the candidate's answer.

    Return only the requested structured output.
    PROMPT;
    }
}
