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
        if (!Schema::hasTable('ai_recommendations')) {
            Schema::create('ai_recommendations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
                $table->foreignId('recommended_post_id')->nullable()->constrained('posts')->onDelete('cascade');
                $table->enum('recommendation_type', ['cultural', 'educational', 'event', 'product'])->nullable();
                $table->decimal('confidence_score', 3, 2)->nullable();
                $table->text('reason')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'recommendation_type']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_recommendations');
    }
};