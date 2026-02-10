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
        // Создаём таблицу прайс-таблиц, только если её нет
        if (! Schema::hasTable('price_tables')) {
            Schema::create('price_tables', function (Blueprint $table) {
                $table->id();
                // sort_order добавлен отдельной миграцией раньше — восстановим его сразу
                $table->unsignedInteger('sort_order')->default(0);
                $table->foreignId('category_id')->constrained('price_categories')->onDelete('cascade');
                $table->string('title');
                $table->timestamps();
            });
        }

        // Создаём таблицу элементов прайса, только если её нет
        if (! Schema::hasTable('price_items')) {
            Schema::create('price_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('table_id')->constrained('price_tables')->onDelete('cascade');
                $table->string('name');
                $table->string('duration');
                $table->string('price');
                $table->timestamps();
            });
        }

        // Если таблицы создались и потребуются корректные значения sort_order для старых данных,
        // можно проинициализировать их здесь, например, по created_at — но обычно админ заполнит записи вручную.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_items');
        Schema::dropIfExists('price_tables');
    }
};
