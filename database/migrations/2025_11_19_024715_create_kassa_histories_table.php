<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void{
        Schema::create('kassa_histories', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['chiqim','xarajat','ish_haqi'])->default('chiqim');
            $table->integer('amount')->default(0);
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_paymart_id')->nullable()->constrained('user_paymarts')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamp('create_data')->nullable();
            $table->timestamp('success_data')->nullable();
            $table->boolean('status')->default(true);
            $table->text('about')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('kassa_histories');
    }
};
