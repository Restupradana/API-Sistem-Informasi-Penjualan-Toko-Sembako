<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransaksiPenjualan;
use App\Models\TransaksiPenjualanDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        $transaksis = TransaksiPenjualan::with('kasir', 'details.produk')->get();
        return response()->json(['status' => true, 'data' => $transaksis], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kasir_id' => 'required|exists:kasirs,id',
            'produk' => 'required|array',
            'produk.*.produk_id' => 'required|exists:produks,id',
            'produk.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $transaksi = TransaksiPenjualan::create([
            'kasir_id' => $request->kasir_id,
        ]);

        $totalPrice = 0;
        foreach ($request->produk as $item) {
            $produk = Produk::find($item['produk_id']);
            $produkTotalPrice = $produk->harga_jual * $item['quantity'];
            $totalPrice += $produkTotalPrice;

            // Kurangi stok produk
            $produk->stok -= $item['quantity'];
            $produk->save();

            TransaksiPenjualanDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item['produk_id'],
                'quantity' => $item['quantity'],
                'total_price' => $produkTotalPrice,
            ]);
        }

        $transaksi->total_price = $totalPrice;
        $transaksi->save();

        return response()->json(['status' => true, 'data' => $transaksi->load('details.produk')], 201);
    }

    public function show($id)
    {
        $transaksi = TransaksiPenjualan::with('kasir', 'details.produk')->find($id);

        if (!$transaksi) {
            return response()->json(['status' => false, 'message' => 'Transaction not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $transaksi], 200);
    }

    public function update(Request $request, $id)
    {
        $transaksi = TransaksiPenjualan::find($id);

        if (!$transaksi) {
            return response()->json(['status' => false, 'message' => 'Transaction not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'kasir_id' => 'required|exists:kasirs,id',
            'produk' => 'required|array',
            'produk.*.produk_id' => 'required|exists:produks,id',
            'produk.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        // Kembalikan stok produk ke jumlah sebelum di-update
        foreach ($transaksi->details as $detail) {
            $produk = Produk::find($detail->produk_id);
            $produk->stok += $detail->quantity;
            $produk->save();
        }

        $transaksi->update(['kasir_id' => $request->kasir_id]);

        // Delete existing details
        $transaksi->details()->delete();

        $totalPrice = 0;
        foreach ($request->produk as $item) {
            $produk = Produk::find($item['produk_id']);
            $produkTotalPrice = $produk->harga_jual * $item['quantity'];
            $totalPrice += $produkTotalPrice;

            // Kurangi stok produk
            $produk->stok -= $item['quantity'];
            $produk->save();

            TransaksiPenjualanDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item['produk_id'],
                'quantity' => $item['quantity'],
                'total_price' => $produkTotalPrice,
            ]);
        }

        $transaksi->total_price = $totalPrice;
        $transaksi->save();

        return response()->json(['status' => true, 'data' => $transaksi->load('details.produk')], 200);
    }

    public function destroy($id)
    {
        $transaksi = TransaksiPenjualan::find($id);

        if (!$transaksi) {
            return response()->json(['status' => false, 'message' => 'Transaction not found'], 404);
        }

        // Kembalikan stok produk sebelum menghapus transaksi
        foreach ($transaksi->details as $detail) {
            $produk = Produk::find($detail->produk_id);
            $produk->stok += $detail->quantity;
            $produk->save();
        }

        $transaksi->details()->delete();
        $transaksi->delete();
        return response()->json(['status' => true, 'message' => 'Transaction deleted'], 200);
    }
}
