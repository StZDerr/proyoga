<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // add slug column (no unique index yet)
        Schema::table('personals', function (Blueprint $table) {
            $table->string('slug', 255)->nullable()->after('last_name');
        });

        // Backfill slugs for existing records and ensure uniqueness
        if (app()->runningInConsole()) {
            $personals = DB::table('personals')->select('id', 'first_name', 'last_name')->get();
            foreach ($personals as $p) {
                $base = Str::slug(trim(($p->first_name ?? '') . ' ' . ($p->last_name ?? '')));
                if (! $base) {
                    $base = 'personal-' . $p->id;
                }

                $slug = $base;
                $i = 1;
                while (DB::table('personals')->where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i++;
                    if ($i > 10000) {
                        // safety break to avoid infinite loop in pathological cases
                        break;
                    }
                }

                DB::table('personals')->where('id', $p->id)->update(['slug' => $slug]);
            }
        }

        // Now add unique index on slug
        Schema::table('personals', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('personals', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
