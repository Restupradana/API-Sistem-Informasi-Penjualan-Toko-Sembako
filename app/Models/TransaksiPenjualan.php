<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    use HasFactory;

    protected $fillable = ['kasir_id', 'total_price'];

    public function kasir()
    {
        return $this->belongsTo(Kasir::class);
    }

    public function details()
    {
        return $this->hasMany(TransaksiPenjualanDetail::class, 'transaksi_id');
    }
}

