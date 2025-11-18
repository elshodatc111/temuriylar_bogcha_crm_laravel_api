<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void{

        Schema::create('kassas', function (Blueprint $table) {
            $table->id();
            $table->integer('kassa_naqt')->default(0);
            $table->integer('kassa_card')->default(0);
            $table->integer('kassa_shot')->default(0);
            $table->integer('kassa_pedding_naqt')->default(0);
            $table->integer('kassa_pedding_card')->default(0);
            $table->integer('kassa_pedding_shot')->default(0);
            $table->integer('teacher_pedding_pay_naqt')->default(0);
            $table->integer('xarajat_pedding_naqt')->default(0);
            $table->timestamps();
        });

    }

    public function down(): void{
        Schema::dropIfExists('kassas');
    }
};
