<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return response()->json(['status' => true, 'data' => $kategoris], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $kategori = Kategori::create($request->all());
        return response()->json(['status' => true, 'data' => $kategori], 201);
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json(['status' => false, 'message' => 'Kategori not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $kategori], 200);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json(['status' => false, 'message' => 'Kategori not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $kategori->update($request->all());
        return response()->json(['status' => true, 'data' => $kategori], 200);
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json(['status' => false, 'message' => 'Kategori not found'], 404);
        }

        $kategori->delete();
        return response()->json(['status' => true, 'message' => 'Kategori deleted'], 200);
    }
}
