<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('saved_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->enum('category', ['read_later', 'favorites', 'inspiration'])->default('favorites');
            $table->timestamps();

            // Índice único para evitar duplicados
            $table->unique(['user_id', 'post_id']);
        });
    }

    public function down() {
        Schema::dropIfExists('saved_items');
    }
};