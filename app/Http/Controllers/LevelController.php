<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index(){
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) values (?, ?, ?)' ,['CUS', 'Pelanggan', now()]);
        // return 'insert data baru berhasil';

        // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);
        // return 'Update data berhasil. Jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
        // return 'Delete data berhasil. Jumlah data yang dihapus: ' .$row. 'baris';

        $data =  DB::select('select * from m_level');
        return view('level',['data' => $data]);
    }

    public function tambah(){
        return view('level_tambah');
}
public function tambah_simpan(StorePostRequest $request): RedirectResponse {

    //The incoming request is valid...

    //Retrive the validated input data...
    $validated = $request->validated();

    //Retrive a portion of the validated input data...
    $validated = $request->safe()->only(['level_kode', 'level_nama']);
    $validated = $request->safe()->except(['level_kode', 'level_nama']);
    return redirect('/level');
    }
}
