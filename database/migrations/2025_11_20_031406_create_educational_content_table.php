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
        if (!Schema::hasTable('educational_content')) {
            Schema::create('educational_content', function (Blueprint $table) {
                $table->id();
                $table->foreignId('post_id')->constrained()->onDelete('cascade');
                $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
                $table->integer('estimated_read_time')->nullable();
                $table->json('learning_objectives')->nullable();
                $table->json('related_topics')->nullable();
                $table->boolean('ai_generated')->default(false);
                $table->string('knowledge_area')->nullable();
                $table->string('historical_period')->nullable();
                $table->text('cultural_significance')->nullable();
                $table->timestamps();

                $table->index(['difficulty_level', 'knowledge_area']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_content');
    }
};