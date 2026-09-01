<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeakingAttemptResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question' => [
                'id' => $this->question->id,
                'part' => $this->question->part,
                'topic' => $this->question->topic,
                'prompt' => $this->question->prompt,
            ],
            'answer' => $this->answer,
            'submitted_at' => $this->submitted_at?->toISOString(),
            'result' => $this->whenLoaded(
                'result',
                fn() => $this->result
                    ? new SpeakingResultResource($this->result)
                    : null
            ),
        ];
    }
}
