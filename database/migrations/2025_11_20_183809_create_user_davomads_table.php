<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('user_davomads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('status', [
                'formada_keldi',
                'formasiz_keldi',
                'ish_kuni_emas',
                'kelmadi',
                'kechikdi',
                'kasal',
                'sababli'
            ])->default('formada_keldi');
            $table->date('data');
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('user_davomads');
    }
};
