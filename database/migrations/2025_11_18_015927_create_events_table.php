<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('max_capacity')->nullable();
            $table->integer('available_slots')->nullable();
            $table->boolean('requires_rsvp')->default(false);
            $table->enum('event_type', ['free', 'paid', 'donation'])->default('free');
            $table->enum('event_status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->timestamps();

            // Índices
            $table->index(['start_date', 'end_date']);
            $table->index('location_id');
            $table->index('organizer_id');
            $table->index('event_status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};