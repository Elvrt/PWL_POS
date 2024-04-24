<?php
namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\UserModel;
use App\Models\StokModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
// Menampilkan halaman awal stok public function index()

public function index(){
        $breadcrumb = (object) [ 
            'title' => 'Daftar stok', 
            'list' => ['Home', 'stok']
    ];

    $page = (object) [
    'title' => 'Daftar stok yang terdaftar dalam sistem'
    ];

    $activeMenu = 'stok'; // set menu yang sedang aktif
    $stok = StokModel::all();
    $user = UserModel::all();
    $barang = BarangModel::all();
    return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'stok'=>$stok, 'user'=>$user,'barang'=>$barang, 'activeMenu' => $activeMenu]);  
}
    public function list(Request $request)
{
    $stoks = StokModel::select('stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
                    ->with(['barang', 'user']);

        //filter data stok berdasarkan stok_id
        if ($request->barang_id){
            $stoks->where('barang_id', $request->barang_id);
        }else if ($request->user_id){
            $stoks->where('user_id', $request->user_id);
        }

    return DataTables::of($stoks)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($stok) { // menambahkan kolom aksi
                $detailUrl = url('/stok/' . $stok->stok_id);
                $editUrl = url('/stok/' . $stok->stok_id . '/edit');
                $deleteUrl = url('/stok/' . $stok->stok_id);

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
            'title' => 'Tambah stok',
            'list' => ['Home', 'stok', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah stok baru'
        ];

        $user = UserModel::all(); //ambil data user untuk ditampilkan di form
        $barang = BarangModel::all(); //ambil data barang untuk ditampilkan di form
        $activeMenu = 'stok'; // set menu yang sedang aktif

        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan data stok baru
    public function store(Request $request)
    {
        $request->validate([
            'barang_id'   => 'required|integer',
            'user_id'     => 'required|integer',
            'stok_tanggal'=> 'required|date_format:Y-m-d\TH:i',
            'stok_jumlah' => 'required|integer'
        ]);

     // Cek apakah stok barang dengan barang_id dan tanggal yang sama sudah ada atau tidak
    $StokAda = StokModel::where('barang_id', $request->barang_id)
    ->where('stok_jumlah', $request->stok_jumlah)
    ->first();

    if ($StokAda) {
    // Jika stok barang sudah ada 
    return redirect('/stok')->with('error', 'Stok barang dengan barang yang sama sudah ada');
    }

        StokModel::create ([
            'barang_id'    => $request->barang_id,
            'user_id'      => $request->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah'  => $request->stok_jumlah,
        ]);

        return redirect('/stok')->with('success','Data stok berhasil disimpan');
    }

    public function show (string $id){
        $stok = StokModel::with('barang')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail stok',
            'list' => ['Home', 'stok', 'Detail']
        ];

        $page =(object) [
            'title' => 'Detail stok'
        ];

        $activeMenu = 'stok';

        return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id) 
    {
        $stok = StokModel::find($id);
        $user = UserModel::all();
        $barang = BarangModel::all();

        $breadcrumb = (object)[
            'title' => 'Edit stok',
            'list' => ['Home', 'stok', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit stok'
        ];

        $activeMenu = 'stok'; //set menu yang sedang aktif
        return view('stok.edit',['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'user' => $user, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan perubahan data stok
public function update(Request $request, string $id)
{
        $request->validate([
            'barang_id'  => 'required|integer',
            'user_id'    => 'required|integer',
            'stok_tanggal'=> 'required|date_format:Y-m-d\TH:i',
            'stok_jumlah' => 'required|integer'
        ]);

        StokModel::find($id)->update([
            'barang_id'   => $request->barang_id,
            'user_id'     => $request->user_id,
            'stok_tanggal'=> $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah,
        ]);

    return redirect('/stok')->with("success", "Data stok berhasil diubah");
}

    //Menghapus data stok
    public function destroy(string $id)
    {
        $check = StokModel::find($id);
        if(!$check){ //untuk mengecek apakah data stok dengan id yang dimaksud ada atau tidak
        return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
    }
    try{
        StokModel::destroy($id); // Hapus data stok

        return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
    } catch(\Illuminate\Database\QueryException $e){
        //jika terjadi  error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
        return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data  ini');
    }
    }

}
