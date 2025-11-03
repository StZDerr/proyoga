<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Добавляем slug только к подподкатегориям (остальные уже есть)
        Schema::table('sub_sub_categories', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('title');
        });
    }

    public function down()
    {
        Schema::table('sub_sub_categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};