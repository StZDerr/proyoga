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
        Schema::table('sub_sub_categories', function (Blueprint $table) {
            $table->string('about_title')->nullable()->after('title');  // "О title"
            $table->string('benefit_title')->nullable()->after('about_title'); // "Польза title"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_sub_categories', function (Blueprint $table) {
            $table->dropColumn(['about_title', 'benefit_title']);
        });
    }
};
