<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->string('media_path');
            $table->enum('media_type', ['image', 'video', 'audio']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_media');
    }
};
