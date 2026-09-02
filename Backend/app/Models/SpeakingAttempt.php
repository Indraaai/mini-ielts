<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SpeakingAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(SpeakingQuestion::class);
    }

    public function result(): HasOne
    {
        return $this->hasOne(
            SpeakingResult::class,
            'attempt_id'
        );
    }
}
