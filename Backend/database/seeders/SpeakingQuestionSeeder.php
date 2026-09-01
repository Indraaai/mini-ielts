<?php

namespace Database\Seeders;

use App\Models\SpeakingQuestion;
use Illuminate\Database\Seeder;

class SpeakingQuestionSeeder extends Seeder
{
    public function run(): void
    {
        SpeakingQuestion::create([
            'part' => 'Part 1',
            'topic' => 'Education',
            'prompt' => 'What do you like most about your studies?',
        ]);

        SpeakingQuestion::create([
            'part' => 'Part 1',
            'topic' => 'Hometown',
            'prompt' => 'Can you tell me something about your hometown?',
        ]);

        SpeakingQuestion::create([
            'part' => 'Part 1',
            'topic' => 'Hobbies',
            'prompt' => 'What do you usually do in your free time?',
        ]);

        SpeakingQuestion::create([
            'part' => 'Part 2',
            'topic' => 'Memorable Experience',
            'prompt' => 'Describe a memorable experience you have had.',
        ]);

        SpeakingQuestion::create([
            'part' => 'Part 2',
            'topic' => 'Person You Admire',
            'prompt' => 'Describe a person you admire and explain why.',
        ]);

        SpeakingQuestion::create([
            'part' => 'Part 3',
            'topic' => 'Education and Society',
            'prompt' => 'How does education influence society?',
        ]);

        SpeakingQuestion::create([
            'part' => 'Part 3',
            'topic' => 'Technology',
            'prompt' => 'How has technology changed the way people communicate?',
        ]);
    }
}