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
        Schema::table('price_tables', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('id');
        });

        // Инициализируем порядок для существующих записей (по created_at, если есть)
        $rows = DB::table('price_tables')->orderBy('created_at')->pluck('id')->toArray();
        $i = 1;
        foreach ($rows as $id) {
            DB::table('price_tables')->where('id', $id)->update(['sort_order' => $i++]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('price_tables', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
