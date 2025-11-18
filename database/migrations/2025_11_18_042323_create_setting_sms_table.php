<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('setting_sms', function (Blueprint $table) {
            $table->id();
            $table->string('login')->nullable();
            $table->string('parol')->nullable();
            $table->text('token')->nullable();
            $table->text('token_data')->nullable();
            $table->boolean('create_child_status')->default(false);
            $table->text('create_child_text')->default("Yangi bola qabul qilinganda yuboriladigan sms.");
            $table->boolean('debet_send_status')->default(false);
            $table->text('debet_send_text')->default("Qarzdorlik mavjud bo'lganda yuboriladigan sms xabar.");
            $table->boolean('paymart_status')->default(false);
            $table->text('paymart_text')->default("To'lov qilganda yuboriladigan sms xabar");
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('setting_sms');
    }

};
