<?php

namespace App\Http\Controllers;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
// Menampilkan halaman awal level public function index()

public function index(){
        $breadcrumb = (object) [ 
            'title' => 'Daftar level', 
            'list' => ['Home', 'level']
    ];

    $page = (object) [
    'title' => 'Daftar level yang terdaftar dalam sistem'
    ];

    $activeMenu = 'level'; // set menu yang sedang aktif
    $level = LevelModel::all();
    return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'level'=>$level, 'activeMenu' => $activeMenu]);  
}
    public function list(Request $request)
{
    $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');
                   

        //filter data level berdasarkan level_id
        if ($request->level_id){
            $levels->where('level_id', $request->level_id);
        }

    return DataTables::of($levels)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($level) { // menambahkan kolom aksi
                $detailUrl = url('/level/' . $level->level_id);
                $editUrl = url('/level/' . $level->level_id . '/edit');
                $deleteUrl = url('/level/' . $level->level_id);

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
            'title' => 'Tambah level',
            'list' => ['Home', 'level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah level baru'
        ];

        $level = LevelModel::all(); //ambil data level untuk ditampilkan di form
        $activeMenu = 'level'; // set menu yang sedang aktif

        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan data level baru
    public function store(Request $request)
    {
        $request->validate([
            //level_kode harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_level kolom level_kode
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100',//nama harus diisi, berupa string dan maksimal 100 karakter
        ]);

        LevelModel::create ([
            'level_kode' => $request->level_kode,
            'level_nama' => $request -> level_nama,
        ]);

        return redirect('/level')->with('success','Data level berhasil disimpan');
    }

    public function show (string $id){
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail level',
            'list' => ['Home', 'level', 'Detail']
        ];

        $page =(object) [
            'title' => 'Detail level'
        ];

        $activeMenu = 'level';

        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id) 
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit level',
            'list' => ['Home', 'level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit level'
        ];

        $activeMenu = 'level'; //set menu yang sedang aktif
        return view('level.edit',['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan perubahan data level
public function update(Request $request, string $id)
{
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:100',
        ]);

        LevelModel::find($id)->update([
            'level_kode'    => $request->level_kode,
            'level_nama'    => $request->level_nama
        ]);

    return redirect('/level')->with("success", "Data level berhasil diubah");
}

    //Menghapus data level
    public function destroy(string $id)
    {
        $check = LevelModel::find($id);
        if(!$check){ //untuk mengecek apakah data level dengan id yang dimaksud ada atau tidak
        return redirect('/level')->with('error', 'Data level tidak ditemukan');
    }
    try{
        LevelModel::destroy($id); // Hapus data level

        return redirect('/level')->with('success', 'Data level berhasil dihapus');
    } catch(\Illuminate\Database\QueryException $e){
        //jika terjadi  error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
        return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data  ini');
    }
    }

}
