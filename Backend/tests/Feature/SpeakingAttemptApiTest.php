<?php

namespace Tests\Feature;

use App\Exceptions\GeminiException;
use App\Models\SpeakingQuestion;
use App\Models\User;
use App\Services\GeminiClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpeakingAttemptApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_rolls_back_the_attempt_when_gemini_evaluation_fails(): void
    {
        $user = User::factory()->create();
        $question = SpeakingQuestion::create([
            'part' => 1,
            'topic' => 'Family',
            'prompt' => 'Describe your family.',
        ]);

        $gemini = \Mockery::mock(GeminiClient::class);
        $gemini->shouldReceive('generate')->andThrow(new GeminiException('Gemini timed out.'));
        $this->app->instance(GeminiClient::class, $gemini);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/speaking/submit', [
                'question_id' => $question->id,
                'answer' => 'I have a happy family and we spend time together every weekend.',
            ]);

        $response->assertStatus(503);
        $this->assertDatabaseCount('speaking_attempts', 0);
        $this->assertDatabaseCount('speaking_results', 0);
    }

    public function test_it_rejects_access_to_another_users_attempt(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $question = SpeakingQuestion::create([
            'part' => 2,
            'topic' => 'Travel',
            'prompt' => 'Describe a memorable trip.',
        ]);

        $attempt = $owner->attempts()->create([
            'question_id' => $question->id,
            'answer' => 'Last year I traveled to Bali with my family and it was unforgettable.',
            'submitted_at' => now(),
        ]);

        $response = $this->actingAs($intruder, 'sanctum')
            ->getJson('/api/speaking/attempts/' . $attempt->id);

        $response->assertStatus(404);
        $response->assertJsonPath('message', 'Speaking attempt not found');
    }
}
