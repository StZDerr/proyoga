<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('spins', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 32)->unique();
            $table->foreignId('prize_id')->nullable()->constrained('prizes')->nullOnDelete();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spins');
    }
};
