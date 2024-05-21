<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;

class BarangController extends Controller
{
    public function index(){
        return BarangModel::all();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $request->file('image')->storeAs('/posts', $request->image->hashName());
            $data['image'] = $request->image->hashName();
        }

        $barang = BarangModel::create($data);
        return response()->json($barang, 201);
    }

    public function show(BarangModel $barang){
        return BarangModel::find($barang);
    }

    public function update(Request $request, $id)
{
    $barang = BarangModel::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('image')) {
        $request->file('image')->storeAs('/posts', $request->image->hashName());
        $data['image'] = $request->image->hashName();
    }
    $barang->update($data);
    return response()->json($barang, 200);
}

    public function destroy(BarangModel $barang){
        $barang->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus'
        ]);
    }
}
