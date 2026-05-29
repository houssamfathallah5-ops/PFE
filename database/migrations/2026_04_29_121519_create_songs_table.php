<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained()->cascadeOnDelete();
            $table->foreignId('artist_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('audio_url')->nullable();
            $table->unsignedInteger('duration')->default(0); // in seconds
            $table->unsignedInteger('track_number')->default(1);
            $table->unsignedBigInteger('play_count')->default(0);
            $table->unsignedBigInteger('like_count')->default(0);
            $table->string('genre')->nullable();
            $table->string('lyrics')->nullable();
            $table->boolean('is_explicit')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
