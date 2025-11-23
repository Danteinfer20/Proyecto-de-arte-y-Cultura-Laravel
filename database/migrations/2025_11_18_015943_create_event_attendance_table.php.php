<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('event_attendance', function (Blueprint $table) {
            $table->id(); // SERIAL PRIMARY KEY
            $table->foreignId('event_id')->constrained()->onDelete('cascade'); // INTEGER NOT NULL REFERENCES events(id)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // INTEGER NOT NULL REFERENCES users(id)
            $table->enum('status', ['confirmed', 'interested', 'not_attending', 'attended'])->default('interested');
            $table->integer('guest_count')->default(0);
            $table->string('qr_code', 100)->unique()->nullable();
            $table->boolean('checked_in')->default(false);
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamps(); // created_at y updated_at

            // Índice único para evitar duplicados (UNIQUE(event_id, user_id))
            $table->unique(['event_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_attendance');
    }
};