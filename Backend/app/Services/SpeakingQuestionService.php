<?php

namespace App\Services;
use App\Repositories\SpeakingQuestionRepository;
use Illuminate\Database\Eloquent\Collection;

class SpeakingQuestionService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private SpeakingQuestionRepository $speakingQuestionRepository
    ) {}

    public function getAllQuestions(): Collection
{
    return $this->speakingQuestionRepository->getAll();
}
}
