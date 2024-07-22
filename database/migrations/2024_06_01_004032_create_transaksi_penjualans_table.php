<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPenjualansTable extends Migration
{
    public function up()
    {
        Schema::create('transaksi_penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasir_id')->constrained('kasirs');
            $table->decimal('total_price', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi_penjualans');
    }
}
