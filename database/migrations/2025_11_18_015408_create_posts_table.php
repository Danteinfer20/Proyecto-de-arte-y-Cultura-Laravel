<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('content_type_id')->constrained()->onDelete('restrict');
            $table->string('title', 200);
            $table->string('slug', 250)->unique();
            $table->text('content');
            $table->string('excerpt', 300)->nullable();
            $table->string('featured_image')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->boolean('allow_comments')->default(true);
            $table->integer('view_count')->default(0);
            $table->integer('share_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Índices
            $table->index(['status', 'published_at']);
            $table->index(['user_id', 'status']);
            $table->index('is_featured');
        });
    }

    public function down() {
        Schema::dropIfExists('posts');
    }
};