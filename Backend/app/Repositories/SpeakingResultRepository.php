<?php

namespace App\Repositories;

use App\Models\SpeakingResult;

class SpeakingResultRepository
{
    public function create(array $data): SpeakingResult
    {
        return SpeakingResult::create($data);
    }
}
