<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('total_price');
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['belum_bayar', 'menunggu_konfirmasi', 'diproses', 'selesai', 'dibatalkan'])->default('belum_bayar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
