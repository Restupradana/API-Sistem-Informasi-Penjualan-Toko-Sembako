<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Kasir extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password'];

    public function transaksiPenjualans()
    {
        return $this->hasMany(TransaksiPenjualan::class);
    }
}

