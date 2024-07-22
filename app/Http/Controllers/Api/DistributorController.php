<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = Distributor::all();
        return response()->json(['status' => true, 'data' => $distributors], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $distributor = Distributor::create($request->all());
        return response()->json(['status' => true, 'data' => $distributor], 201);
    }

    public function show($id)
    {
        $distributor = Distributor::find($id);

        if (!$distributor) {
            return response()->json(['status' => false, 'message' => 'Distributor not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $distributor], 200);
    }

    public function update(Request $request, $id)
    {
        $distributor = Distributor::find($id);

        if (!$distributor) {
            return response()->json(['status' => false, 'message' => 'Distributor not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $distributor->update($request->all());
        return response()->json(['status' => true, 'data' => $distributor], 200);
    }

    public function destroy($id)
    {
        $distributor = Distributor::find($id);

        if (!$distributor) {
            return response()->json(['status' => false, 'message' => 'Distributor not found'], 404);
        }

        $distributor->delete();
        return response()->json(['status' => true, 'message' => 'Distributor deleted'], 200);
    }
}
