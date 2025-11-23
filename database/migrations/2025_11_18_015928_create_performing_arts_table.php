<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('performing_arts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->enum('art_type', ['circus', 'theater', 'dance', 'performance', 'magic']);
            $table->integer('duration_minutes')->nullable();
            $table->string('artistic_director', 150)->nullable();
            $table->string('company', 150)->nullable();
            $table->string('genre', 100)->nullable();
            $table->string('target_audience', 50)->nullable();
            $table->text('technical_requirements')->nullable();
            $table->json('cast_members')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('performing_arts');
    }
};