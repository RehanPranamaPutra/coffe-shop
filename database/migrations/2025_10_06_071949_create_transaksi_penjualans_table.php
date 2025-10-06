<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('promo_id')->constrained('promos');
            $table->string('kode_transaksi')->unique();
            $table->integer('jumlah');
            $table->decimal('harga_satuan',12,2);
            $table->decimal('total',12,2);
            $table->decimal('potongan',12,2)->nullable();
            $table->decimal('total_bayar',12,2)->nullable();
            $table->decimal('dibayar',12,2)->nullable();
            $table->decimal('kembalian',12,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_penjualans');
    }
};
