<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->integer('post_count')->default(0);
            $table->integer('follower_count')->default(0);
            $table->integer('following_count')->default(0);
            $table->integer('event_count')->default(0);
            $table->integer('attendance_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->integer('sales_count')->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0.00);
            $table->timestamps();
            
            // Índice
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_statistics');
    }
};