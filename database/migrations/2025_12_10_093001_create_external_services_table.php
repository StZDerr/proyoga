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
        Schema::create('external_services', function (Blueprint $table) {
            $table->id();

            $table->string('name');         // Название сервиса: Yandex Metrika, GA4, VK Pixel
            $table->string('key')->nullable();    // Идентификатор, например: "YA_METRIKA_ID"
            $table->string('token')->nullable();  // Токены, API-ключи
            $table->text('script')->nullable();   // Встраиваемый JS-код (метрика, пиксели)
            $table->json('config')->nullable();   // Дополнительные настройки

            $table->boolean('active')->default(true); // Включено ли подключение

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_services');
    }
};
