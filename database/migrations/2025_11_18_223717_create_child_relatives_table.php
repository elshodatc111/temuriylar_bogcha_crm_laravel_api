<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void{
        Schema::create('child_relatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->text('about')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('child_relatives');
    }

};
