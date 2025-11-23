<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['new_follower', 'comment', 'reaction', 'event_reminder', 'message', 'sale', 'system']);
            $table->string('title', 200);
            $table->text('message');
            $table->string('action_url')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            // Índices
            $table->index('user_id');
            $table->index('is_read');
            $table->index('created_at');
        });
    }

    public function down() {
        Schema::dropIfExists('notifications');
    }
};