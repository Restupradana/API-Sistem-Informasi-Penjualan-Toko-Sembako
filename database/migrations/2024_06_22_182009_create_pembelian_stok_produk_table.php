<?php

// database/migrations/yyyy_mm_dd_create_pembelian_stok_produk_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianStokProdukTable extends Migration
{
    public function up()
    {
        Schema::create('pembelian_stok_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('harga_beli', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembelian_stok_produk');
    }
}
