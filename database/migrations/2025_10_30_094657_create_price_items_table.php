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
        Schema::create('price_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained('price_tables')->onDelete('cascade');
            $table->string('name'); // "Разовое групповое занятие"
            $table->string('duration'); // "55 мин"
            $table->string('price'); // "700 ₽"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_items');
    }
};
