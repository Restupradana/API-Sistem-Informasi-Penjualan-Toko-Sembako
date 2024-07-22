<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualanDetail extends Model
{
    use HasFactory;

    protected $fillable = ['transaksi_id', 'produk_id', 'quantity', 'total_price'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(TransaksiPenjualan::class);
    }
}
