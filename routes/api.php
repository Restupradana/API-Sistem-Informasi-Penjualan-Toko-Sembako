<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\DistributorController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\KasirController;
use App\Http\Controllers\Api\PembelianStokProdukController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('kategori', KategoriController::class);
Route::apiResource('distributor', DistributorController::class);
Route::apiResource('produk', ProdukController::class);
Route::post('produk/{id}/beli', [ProdukController::class, 'beliProduk']);
Route::apiResource('kasir', KasirController::class);

use App\Http\Controllers\API\UserController;
Route::apiResource('users', UserController::class);

use App\Http\Controllers\Api\TransaksiPenjualanController;
Route::apiResource('transaksi-penjualan', TransaksiPenjualanController::class);



Route::apiResource('pembelian-stok-produk', PembelianStokProdukController::class);



