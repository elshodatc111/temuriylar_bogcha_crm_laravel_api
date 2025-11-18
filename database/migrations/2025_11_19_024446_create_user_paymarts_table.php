<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void{
        Schema::create('user_paymarts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->boolean('status')->default(false);
            $table->integer('amount')->default(0);
            $table->enum('type', ['naqt','card','shot'])->default('naqt');
            $table->text('about')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('user_paymarts');
    }

};
