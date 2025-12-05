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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');          // Заголовок статьи
            $table->string('slug')->unique(); // Для ЧПУ
            $table->text('excerpt')->nullable(); // Короткое описание
            $table->longText('content');      // Основной текст с CKEditor
            $table->string('image')->nullable(); // Обложка
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
