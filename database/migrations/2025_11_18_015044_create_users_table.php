<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->enum('user_type', ['artist', 'cultural_manager', 'visitor', 'admin'])->default('visitor');
            $table->date('birth_date')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('city', 100)->default('Popayán');
            $table->string('neighborhood', 100)->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('cover_picture')->nullable();
            $table->string('website')->nullable();
            $table->json('social_media')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->enum('status', ['active', 'suspended', 'inactive'])->default('active');
            $table->boolean('is_verified')->default(false);
            $table->rememberToken();
            $table->timestamps();

            // Índices
            $table->index('email');
            $table->index('username');
            $table->index('user_type');
            $table->index('status');
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};