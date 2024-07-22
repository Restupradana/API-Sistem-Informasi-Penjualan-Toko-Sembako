<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PembelianStokProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembelianStokProdukController extends Controller
{
    public function index()
    {
        $pembelianStokProduks = PembelianStokProduk::all();
        return response()->json(['status' => true, 'data' => $pembelianStokProduks], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|integer',
            'quantity' => 'required|integer',
            'harga_beli' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $pembelianStokProduk = PembelianStokProduk::create($request->all());
        return response()->json(['status' => true, 'data' => $pembelianStokProduk], 201);
    }

    public function show($id)
    {
        $pembelianStokProduk = PembelianStokProduk::find($id);

        if (!$pembelianStokProduk) {
            return response()->json(['status' => false, 'message' => 'PembelianStokProduk not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $pembelianStokProduk], 200);
    }

    public function update(Request $request, $id)
    {
        $pembelianStokProduk = PembelianStokProduk::find($id);

        if (!$pembelianStokProduk) {
            return response()->json(['status' => false, 'message' => 'PembelianStokProduk not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|integer',
            'quantity' => 'required|integer',
            'harga_beli' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $pembelianStokProduk->update($request->all());
        return response()->json(['status' => true, 'data' => $pembelianStokProduk], 200);
    }

    public function destroy($id)
    {
        $pembelianStokProduk = PembelianStokProduk::find($id);

        if (!$pembelianStokProduk) {
            return response()->json(['status' => false, 'message' => 'PembelianStokProduk not found'], 404);
        }

        $pembelianStokProduk->delete();
        return response()->json(['status' => true, 'message' => 'PembelianStokProduk deleted'], 200);
    }
}
