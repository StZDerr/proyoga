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
        Schema::create('indexing_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('global_indexing_enabled')->default(true);
            $table->text('robots_txt_content')->nullable();
            $table->boolean('sitemap_enabled')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indexing_settings');
    }
};
