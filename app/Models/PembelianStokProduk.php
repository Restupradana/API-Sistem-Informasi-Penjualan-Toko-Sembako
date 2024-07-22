<?php

// app/Models/PembelianStokProduk.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianStokProduk extends Model
{
    use HasFactory;

    protected $table = 'pembelian_stok_produk';
    protected $fillable = ['produk_id', 'quantity', 'harga_beli'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
