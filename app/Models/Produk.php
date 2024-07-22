<?php

// app/Models/Produk.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    protected $fillable = ['name', 'harga_beli', 'harga_jual', 'stok', 'kategori_id', 'distributor_id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'distributor_id');
    }

    public function pembelianStokProduks()
    {
        return $this->hasMany(PembelianStokProduk::class, 'produk_id');
    }
}
