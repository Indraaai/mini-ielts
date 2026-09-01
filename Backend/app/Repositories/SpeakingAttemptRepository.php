<?php

namespace App\Repositories;

use App\Models\SpeakingAttempt;
use Illuminate\Database\Eloquent\Collection;

class SpeakingAttemptRepository
{
    public function create(array $data): SpeakingAttempt
    {
        return SpeakingAttempt::create($data);
    }

    public function getByUserId(int $userId)
    {
        return SpeakingAttempt::query()
            ->with(['question', 'result'])
            ->where('user_id', $userId)
            ->latest('submitted_at')
            ->get();
    }
    public function findByUserId(
        int $userId,
        int $attemptId
    ): ?SpeakingAttempt {
        return SpeakingAttempt::query()
            ->with(['question', 'result'])
            ->where('user_id', $userId)
            ->where('id', $attemptId)
            ->first();
    }
}
