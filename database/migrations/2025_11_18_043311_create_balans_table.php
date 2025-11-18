<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void{
        Schema::create('balans', function (Blueprint $table) {
            $table->id();
            $table->integer('naqt')->default(0);
            $table->integer('card')->default(0);
            $table->integer('shot')->default(0);
            $table->integer('exson_naqt')->default(0);
            $table->integer('exson_card')->default(0);
            $table->integer('exson_shot')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('balans');
    }
};
