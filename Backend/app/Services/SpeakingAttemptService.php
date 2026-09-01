<?php

namespace App\Services;

use App\Models\SpeakingAttempt;
use App\Repositories\SpeakingAttemptRepository;
use Illuminate\Database\Eloquent\Collection;

class SpeakingAttemptService
{
    public function __construct(
        private SpeakingAttemptRepository $speakingAttemptRepository
    ) {}

    public function submit(
        int $userId,
        array $data
    ): SpeakingAttempt {
        return $this->speakingAttemptRepository->create([
            'user_id' => $userId,
            'question_id' => $data['question_id'],
            'answer' => $data['answer'],
            'submitted_at' => now(),
        ]);
    }

    public function getByUserId(
        int $userId
    ): Collection {
        return $this->speakingAttemptRepository->getByUserId(
            $userId
        );
    }

    public function getByIdAndUserId(
        int $attemptId,
        int $userId
    ): ?SpeakingAttempt {
        return $this->speakingAttemptRepository->findByUserId(
            $userId,
            $attemptId
        );
    }
}
