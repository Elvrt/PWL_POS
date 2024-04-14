<?php
namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
// Menampilkan halaman awal user public function index()

public function index(){
        $breadcrumb = (object) [ 
            'title' => 'Daftar User', 
            'list' => ['Home', 'User']
    ];

    $page = (object) [
    'title' => 'Daftar user yang terdaftar dalam sistem'
    ];

    $activeMenu = 'user'; // set menu yang sedang aktif
    $level = LevelModel::all();
    return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'level'=>$level, 'activeMenu' => $activeMenu]);  
}
    public function list(Request $request)
{
    $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
                    ->with('level');

        //filter data user berdasarkan level_id
        if ($request->level_id){
            $users->where('level_id', $request->level_id);
        }

    return DataTables::of($users)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
                $detailUrl = url('/user/' . $user->user_id);
                $editUrl = url('/user/' . $user->user_id . '/edit');
                $deleteUrl = url('/user/' . $user->user_id);

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
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all(); //ambil data level untuk ditampilkan di form
        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan data user baru
    public function store(Request $request)
    {
        $request->validate([
            //username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',//nama harus diisi, berupa string dan maksimal 100 karakter
            'password' => 'required|min:5', //password harus diisi dan minimal 5 karakter
            'level_id' => 'required|integer' //level_id harus diisi dan berupa angka
        ]);

        UserModel::create ([
            'username' => $request->username,
            'nama' => $request -> nama,
            'password' => bcrypt($request->password), // password dienkripsi sebelum disimpan
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success','Data user berhasil disimpan');
    }

    public function show (string $id){
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page =(object) [
            'title' => 'Detail User'
        ];

        $activeMenu = 'user';

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id) 
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object)[
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit User'
        ];

        $activeMenu = 'user'; //set menu yang sedang aktif
        return view('user.edit',['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan perubahan data user
public function update(Request $request, string $id)
{
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);

        $user = UserModel::find($id);
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = $request->password ? bcrypt($request->password) : $user->password;
        $user->level_id = $request->level_id;
        $user->save();

    return redirect('/user')->with("success", "Data user berhasil diubah");
}

    //Menghapus data user
    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if(!$check){ //untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
        return redirect('/user')->with('error', 'Data user tidak ditemukan');
    }
    try{
        UserModel::destroy($id); // Hapus data level

        return redirect('/user')->with('success', 'Data user berhasil dihapus');
    } catch(\Illuminate\Database\QueryException $e){
        //jika terjadi  error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
        return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data  ini');
    }
    }

}
