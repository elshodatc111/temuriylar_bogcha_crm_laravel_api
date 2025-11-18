<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('balans_histories', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['naqt','card','shot'])->default('naqt');
            $table->enum('status', [
                                'kassa_chiqim',
                                'kassa_xarajat',
                                'kassa_ish_haqi',
                                'ish_haqi_naqt',
                                'ish_haqi_card',
                                'ish_haqi_shot',
                                'xarajat_naqt',
                                'xarajat_card',
                                'xarajat_shot',
                                'exson_naqt',
                                'exson_card',
                                'exson_shot',
                                'daromad_naqt',
                                'daromad_card',
                                'daromad_shot'
                            ]);
            $table->integer('amount')->default(0);
            $table->text('about')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('balans_histories');
    }
};
