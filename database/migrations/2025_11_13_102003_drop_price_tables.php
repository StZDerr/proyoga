<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('price_items');
        Schema::dropIfExists('price_tables');
    }

    public function down(): void
    {
        // если захочешь вернуть таблицы, можешь восстановить их структуру
        Schema::create('price_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('price_categories')->onDelete('cascade');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('price_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained('price_tables')->onDelete('cascade');
            $table->string('name');
            $table->string('duration');
            $table->string('price');
            $table->timestamps();
        });
    }
};
