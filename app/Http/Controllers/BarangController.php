<?php
namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class barangController extends Controller
{
// Menampilkan halaman awal barang public function index()

public function index(){
        $breadcrumb = (object) [ 
            'title' => 'Daftar barang', 
            'list' => ['Home', 'barang']
    ];

    $page = (object) [
    'title' => 'Daftar barang yang terdaftar dalam sistem'
    ];

    $activeMenu = 'barang'; // set menu yang sedang aktif
    $kategori = KategoriModel::all();
    return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'kategori'=>$kategori, 'activeMenu' => $activeMenu]);  
}
    public function list(Request $request)
{
    $barangs = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'kategori_id', 'harga_beli', 'harga_jual')
                    ->with('kategori');

        //filter data barang berdasarkan kategori_id
        if ($request->kategori_id){
            $barangs->where('kategori_id', $request->kategori_id);
        }

    return DataTables::of($barangs)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi
                $detailUrl = url('/barang/' . $barang->barang_id);
                $editUrl = url('/barang/' . $barang->barang_id . '/edit');
                $deleteUrl = url('/barang/' . $barang->barang_id);

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
            'title' => 'Tambah barang',
            'list' => ['Home', 'barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah barang baru'
        ];

        $kategori = kategoriModel::all(); //ambil data barang untuk ditampilkan di form
        $activeMenu = 'barang'; // set menu yang sedang aktif

        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan data barang baru
    public function store(Request $request)
    {
        $request->validate([
            //barang_kode harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_barang kolom barangname
            'barang_kode'  => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama'  => 'required|string|max:100',
            'kategori_id'  => 'required|integer',
            'harga_beli'   => 'required|integer',
            'harga_jual'   => 'required|integer'
        ]);

        BarangModel::create ([
            'barang_kode'    => $request->barang_kode,
            'barang_nama'    => $request->barang_nama,
            'kategori_id'    => $request->kategori_id,
            'harga_beli'     => $request->harga_beli,
            'harga_jual'     => $request->harga_jual
        ]);

        return redirect('/barang')->with('success','Data barang berhasil disimpan');
    }

    public function show (string $id){
        $barang = BarangModel::with('kategori')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail barang',
            'list' => ['Home', 'barang', 'Detail']
        ];

        $page =(object) [
            'title' => 'Detail barang'
        ];

        $activeMenu = 'barang';

        return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id) 
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();

        $breadcrumb = (object)[
            'title' => 'Edit barang',
            'list' => ['Home', 'barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit barang'
        ];

        $activeMenu = 'barang'; //set menu yang sedang aktif
        return view('barang.edit',['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan perubahan data barang
public function update(Request $request, string $id)
{
        $request->validate([
            'barang_kode'  => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama'  => 'required|string|max:100',
            'kategori_id'  => 'required|integer',
            'harga_beli'   => 'required|integer',
            'harga_jual'   => 'required|integer',
        ]);

        BarangModel::find($id)->update([
            'barang_kode'    => $request->barang_kode,
            'barang_nama'    => $request->barang_nama,
            'kategori_id'    => $request->kategori_id,
            'harga_beli'     => $request->harga_beli,
            'harga_jual'     => $request->harga_jual
        ]);

    return redirect('/barang')->with("success", "Data barang berhasil diubah");
}

    //Menghapus data barang
    public function destroy(string $id)
    {
        $check = BarangModel::find($id);
        if(!$check){ //untuk mengecek apakah data barang dengan id yang dimaksud ada atau tidak
        return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
    }
    try{
        BarangModel::destroy($id); // Hapus data Barang
        return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
    } catch(\Illuminate\Database\QueryException $e){
        //jika terjadi  error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
        return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data  ini');
    }
    }

}
