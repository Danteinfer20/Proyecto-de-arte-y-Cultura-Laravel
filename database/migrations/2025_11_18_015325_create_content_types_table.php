<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('content_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->boolean('allows_events')->default(false);
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('content_types');
    }
};