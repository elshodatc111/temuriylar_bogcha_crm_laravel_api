<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void{
        Schema::create('setting_paymarts', function (Blueprint $table) {
            $table->id();
            $table->integer('exson_foiz')->default(0);
            $table->integer('bonus_80_plus')->default(0);
            $table->integer('bonus_85_plus')->default(0);
            $table->integer('bonus_90_plus')->default(0);
            $table->integer('bonus_95_plus')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('setting_paymarts');
    }
};
