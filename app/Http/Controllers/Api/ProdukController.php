<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PembelianStokProduk;

class ProdukController extends Controller
{
    // Menampilkan semua produk
    public function index()
    {
        $products = Produk::with(['distributor', 'kategori'])->get();
        return response()->json(['status' => true, 'data' => $products], 200);
    }

    // Menyimpan produk baru ke database
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
            'distributor_id' => 'required|exists:distributors,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $product = Produk::create($request->all());
        return response()->json(['status' => true, 'data' => $product], 201);
    }

    // Menampilkan detail produk
    public function show($id)
    {
        $product = Produk::with(['distributor', 'kategori'])->find($id);

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $product], 200);
    }

    // Memperbarui data produk
    public function update(Request $request, $id)
    {
        $product = Produk::find($id);

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
            'distributor_id' => 'required|exists:distributors,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $product->update($request->all());
        return response()->json(['status' => true, 'data' => $product], 200);
    }

    // Menghapus produk
    public function destroy($id)
    {
        $product = Produk::find($id);

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['status' => true, 'message' => 'Product deleted'], 200);
    }

    public function beliProduk(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:0',
        ]);

        $produk = Produk::findOrFail($id);

        // Simpan pembelian stok produk
        $pembelian = new PembelianStokProduk([
            'quantity' => $request->quantity,
            'harga_beli' => $request->harga_beli,
        ]);

        $produk->pembelianStokProduks()->save($pembelian);

        // Tambah stok produk
        $produk->increment('stok', $request->quantity);

        return response()->json(['message' => 'Pembelian berhasil'], 200);
    }
    
}
