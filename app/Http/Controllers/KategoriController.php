<?php

namespace App\Http\Controllers;


use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
// Menampilkan halaman awal 
public function index(){
        $breadcrumb = (object) [ 
            'title' => 'Daftar Kategori Barang', 
            'list' => ['Home', 'Kategori']
    ];

    $page = (object) [
    'title' => 'Daftar kategori barang yang terdaftar dalam sistem'
    ];

    $activeMenu = 'kategori'; // set menu yang sedang aktif
    $kategori = KategoriModel::all();
    return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'kategori'=>$kategori, 'activeMenu' => $activeMenu]);  
}
    public function list(Request $request)
{
    $categories = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');
                   

        //filter data 
        if ($request->kategori_id){
            $categories->where('kategori_id', $request->kategori_id);
        }

    return DataTables::of($categories)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($kategori) { // menambahkan kolom aksi
                $detailUrl = url('/kategori/' . $kategori->kategori_id);
                $editUrl = url('/kategori/' . $kategori->kategori_id . '/edit');
                $deleteUrl = url('/kategori/' . $kategori->kategori_id);

                $btn = '<a href="' . $detailUrl . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . $editUrl . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . $deleteUrl . '">'
                        . csrf_field() . method_field('DELETE')
                        . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
}

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];

        $kategori = KategoriModel::all(); //ambil data kategori untuk ditampilkan di form
        $activeMenu = 'kategori'; // set menu yang sedang aktif

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan data kategori baru
    public function store(Request $request)
    {
        $request->validate([
            //kategori harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_kategori kolom kategori_kode
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100',//nama harus diisi, berupa string dan maksimal 100 karakter
        ]);

        KategoriModel::create ([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request -> kategori_nama,
        ]);

        return redirect('/kategori')->with('success','Data kategori berhasil disimpan');
    }

    public function show (string $id){
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page =(object) [
            'title' => 'Detail Kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id) 
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Kategori'
        ];

        $activeMenu = 'kategori'; //set menu yang sedang aktif
        return view('kategori.edit',['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori,'activeMenu' => $activeMenu]);
    }

    //Menyimpan perubahan data kategori
public function update(Request $request, string $id)
{
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100',
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode'    => $request->kategori_kode,
            'kategori_nama'        => $request->kategori_nama,
        ]);

    return redirect('/kategori')->with("success", "Data kategori berhasil diubah");
}

    //Menghapus data kategori
    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);
        if(!$check){ //untuk mengecek apakah data dengan id yang dimaksud ada atau tidak
        return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
    }
    try{
        KategoriModel::destroy($id); // Hapus data level

        return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
    } catch(\Illuminate\Database\QueryException $e){
        //jika terjadi  error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
        return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
    }
    }

}
