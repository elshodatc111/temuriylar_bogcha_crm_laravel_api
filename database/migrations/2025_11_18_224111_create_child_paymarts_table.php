<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('child_paymarts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('child_relative_id')->nullable()->constrained('child_relatives')->cascadeOnUpdate()->nullOnDelete();
            $table->integer('amount');
            $table->enum('type', ['naqt', 'card', 'shot']);
            $table->text('about')->nullable();
            $table->boolean('status')->default(false);
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('child_paymarts');
    }
};
