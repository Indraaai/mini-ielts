<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeakingResultResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'attempt_id' => $this->attempt_id,
            'estimated_band' => (float) $this->estimated_band,
            'strengths' => $this->strengths,
            'areas_to_improve' => $this->areas_to_improve,
            'feedback' => $this->feedback,
        ];
    }
}
