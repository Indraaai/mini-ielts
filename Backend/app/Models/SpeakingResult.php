<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpeakingResult extends Model
{
    protected $fillable = [
        'attempt_id',
        'estimated_band',
        'strengths',
        'areas_to_improve',
        'feedback',
    ];

    protected $casts = [
        'estimated_band' => 'decimal:1',
        'strengths' => 'array',
        'areas_to_improve' => 'array',
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(SpeakingAttempt::class);
    }
}