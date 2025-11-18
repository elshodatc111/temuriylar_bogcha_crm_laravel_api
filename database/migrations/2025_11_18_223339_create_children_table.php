<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('seria')->unique()->nullable();
            $table->date('tkun')->nullable();
            $table->boolean('status')->default(false);
            $table->integer('balans')->default(0);
            $table->date('balans_data')->nullable();
            $table->boolean('guvohnoma')->default(false);
            $table->boolean('passport')->default(false);
            $table->boolean('gepatet')->default(false);
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('children');
    }
};
