<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('story_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained('stories')->onDelete('cascade');
            $table->enum('type', ['photo', 'video']);
            $table->string('path');
            $table->unsignedInteger('sort')->nullable()->default(null);
            $table->timestamps();
        });

        // индекс для быстрого поиска
        Schema::table('story_media', function (Blueprint $table) {
            $table->index(['story_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('story_media');
    }
};
