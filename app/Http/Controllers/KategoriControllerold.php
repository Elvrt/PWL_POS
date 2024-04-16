<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\RedirectResponse;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
    }

    public function create(){
        return view('kategori.create');
    }

    // public function store(Request $request){
    //     KategoriModel::create([
    //         'kategori_kode' => $request->kodeKategori,
    //         'kategori_nama'=> $request->namaKategori,
    //     ]);
    //     return redirect('/kategori');
    // }

    public function edit($id) {
        $kategori = KategoriModel::find($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function delete($id){
    $kategori = KategoriModel::find($id);
    if (!$kategori) {
        abort(404);
    }
    
    $kategori->delete();
    
    return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }

    
    public function update(Request $request, $id)
    {
        $kategori = KategoriModel::find($id);
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->kategori_nama = $request->kategori_nama;
        $kategori->save();

        return redirect('/kategori')->with('success', 'Kategori berhasil diupdate');
    }

    // public function store(Request $request) : RedirectResponse  {
    //     $validated = $request->validate([
    //         'kategori_kode' => $request->kodeKategori,
    //         'kategori_nama'=> $request->namaKategori,
    //     ]);
    //     return redirect('/kategori');
    // }

    public function store(Request $request) : RedirectResponse  {
        $validated = $request->validate([
            // 'kategori_kode' => ['required', 'unique:m_kategori', 'max:10'],
            // 'kategori_nama'=> ['required']

            'kategori_kode' => 'bail|required|unique:m_kategori|max:10',
            'kategori_nama'=> 'bail|required|unique:m_kategori',
        ]);
        return redirect('/kategori');
    }



}
  
