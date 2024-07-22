<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class KasirController extends Controller
{
    public function index()
    {
        $kasirs = Kasir::all();
        return response()->json(['status' => true, 'data' => $kasirs], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:kasirs',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $kasir = Kasir::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['status' => true, 'data' => $kasir], 201);
    }

    public function show($id)
    {
        $kasir = Kasir::find($id);

        if (!$kasir) {
            return response()->json(['status' => false, 'message' => 'Kasir not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $kasir], 200);
    }

    public function update(Request $request, $id)
    {
        $kasir = Kasir::find($id);

        if (!$kasir) {
            return response()->json(['status' => false, 'message' => 'Kasir not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:kasirs,email,' . $kasir->id,
            'password' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $kasir->update($data);

        return response()->json(['status' => true, 'data' => $kasir], 200);
    }

    public function destroy($id)
    {
        $kasir = Kasir::find($id);

        if (!$kasir) {
            return response()->json(['status' => false, 'message' => 'Kasir not found'], 404);
        }

        $kasir->delete();
        return response()->json(['status' => true, 'message' => 'Kasir deleted'], 200);
    }
}
