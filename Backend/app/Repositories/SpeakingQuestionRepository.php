<?php

namespace App\Repositories;

use App\Models\SpeakingQuestion;
use Illuminate\Database\Eloquent\Collection;

class SpeakingQuestionRepository
{
    public function getAll(): Collection
    {
        return SpeakingQuestion::query()
            ->get();
    }
}