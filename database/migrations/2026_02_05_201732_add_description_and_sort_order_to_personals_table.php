<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('personals', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('position');
            $table->text('description')->nullable()->after('sort_order');
        });
    }

    public function down()
    {
        Schema::table('personals', function (Blueprint $table) {
            $table->dropColumn(['sort_order', 'description']);
        });
    }
};
