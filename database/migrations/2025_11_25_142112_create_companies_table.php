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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название
            $table->string('category'); // Категория
            $table->text('advantages')->nullable(); // Перечисление преимуществ через перенос строки
            $table->string('phone')->nullable(); // Телефон
            $table->string('email')->nullable(); // Email
            $table->string('photo')->nullable(); // Фото
            $table->json('socials')->nullable(); // Соцсети для генерации блока с иконками
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
