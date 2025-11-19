<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('group_tarbiyachis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete();
            $table->boolean('status')->default(true);
            $table->date('start_data')->nullable();
            $table->foreignId('start_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('start_about')->nullable();
            $table->date('end_data')->nullable();
            $table->foreignId('end_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('end_about')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('group_tarbiyachis');
    }
};
