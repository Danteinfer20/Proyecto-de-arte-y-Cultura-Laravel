<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('address', 255);
            $table->string('neighborhood', 100)->nullable();
            $table->string('city', 100)->default('Popayán');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('location_type', ['museum', 'theater', 'gallery', 'street', 'park', 'cultural_center', 'auditorium', 'library'])->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('opening_hours', 200)->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->string('website')->nullable();
            $table->integer('capacity')->nullable();
            $table->boolean('is_accessible')->default(true);
            $table->timestamps();

            // Índices
            $table->index('city');
            $table->index('location_type');
        });
    }

    public function down() {
        Schema::dropIfExists('locations');
    }
};