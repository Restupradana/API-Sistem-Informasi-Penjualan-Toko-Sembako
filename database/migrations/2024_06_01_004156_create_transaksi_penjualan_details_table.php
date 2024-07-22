<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPenjualanDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('transaksi_penjualan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi_penjualans');
            $table->foreignId('produk_id')->constrained('produks');
            $table->integer('quantity');
            $table->decimal('total_price', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi_penjualan_details');
    }
}
