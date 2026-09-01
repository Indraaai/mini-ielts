<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('speaking_results', function (Blueprint $table) {
        $table->id();

        $table->foreignId('attempt_id')
            ->unique()
            ->constrained('speaking_attempts')
            ->cascadeOnDelete();

        $table->decimal('estimated_band', 2, 1);
        $table->json('strengths');
        $table->json('areas_to_improve');
        $table->text('feedback')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speaking_results');
    }
};
