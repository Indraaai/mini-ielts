<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitSpeakingAttemptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question_id' => [
                'required',
                'integer',
                'exists:speaking_questions,id',
            ],
            'answer' => [
                'required',
                'string',
                'min:10',
                'max:500',
            ],
        ];
    }
}
