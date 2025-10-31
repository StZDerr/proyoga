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
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->comment('URL slug страницы (home, about, services)');
            $table->string('title')->comment('Заголовок страницы для <title>');
            $table->text('description')->nullable()->comment('Описание страницы для meta description');
            $table->text('keywords')->nullable()->comment('Ключевые слова для meta keywords');
            $table->longText('content')->nullable()->comment('Основной контент страницы');
            $table->json('seo_data')->nullable()->comment('Дополнительные SEO данные');
            $table->boolean('is_active')->default(true)->comment('Активна ли страница');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
