<?php
namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanModel;
use App\Models\DetailPenjualanModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class penjualanController extends Controller
{
// Menampilkan halaman awal penjualan public function index()

public function index(){
        $breadcrumb = (object) [ 
            'title' => 'Daftar penjualan', 
            'list' => ['Home', 'penjualan']
    ];

    $page = (object) [
    'title' => 'Daftar penjualan yang terdaftar dalam sistem'
    ];

    $activeMenu = 'penjualan'; // set menu yang sedang aktif
    $user = UserModel::all();
    $barang = BarangModel::all();
    $penjualan = PenjualanModel::all();
    return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'user'=>$user,'penjualan'=>$penjualan, 'barang'=>$barang , 'activeMenu' => $activeMenu]);  
}
    public function list(Request $request)
{
    $penjualans = penjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')
                    ->with('user')
                    ->withCount(['detail as jumlah' => function($query) {
                        $query->select(DB::raw('sum(jumlah)'));
                    }]);

        //filter data penjualan berdasarkan penjualan_id
        if ($request->user_id){
            $penjualans->where('user_id', $request->user_id);
        }

    return DataTables::of($penjualans)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
                $detailUrl = url('/penjualan/' . $penjualan->penjualan_id);
                $editUrl = url('/penjualan/' . $penjualan->penjualan_id . '/edit');
                $deleteUrl = url('/penjualan/' . $penjualan->penjualan_id);

                $btn = '<a href="' . $detailUrl . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . $editUrl . '" class="btn btn-warning btn-sm">Edit</a> ';
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
            'title' => 'Tambah penjualan',
            'list' => ['Home', 'penjualan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah penjualan baru'
        ];

        $user = UserModel::all(); //ambil data user untuk ditampilkan di form
        $barang = BarangModel::all();
        $activeMenu = 'penjualan'; // set menu yang sedang aktif

        return view('penjualan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'user'=>$user, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan data penjualan baru
    public function store(Request $request)
    {
        $request->validate([
            'penjualan_kode'   => 'required|string|min:3|unique:t_penjualan,penjualan_kode',
            'user_id'          => 'required|integer',
            'pembeli'          => 'required|string|max:100',
            'penjualan_tanggal'=> 'required|date_format:Y-m-d\TH:i',
            'barang_id'        => 'required|integer',
            'jumlah'           => 'required|integer'
        ]);
        $penjualan = PenjualanModel::create([
            'penjualan_kode'   => $request->penjualan_kode,
            'user_id'          => $request->user_id,
            'pembeli'          => $request->pembeli,
            'penjualan_tanggal'=> $request->penjualan_tanggal
        ]);

        //detail penjualan
        $barang = BarangModel::findOrFail($request->barang_id);
        $harga = $barang->harga_jual;
        $penjualan_id = $penjualan->penjualan_id;

        DetailPenjualanModel::create([
            'penjualan_id'=> $penjualan_id,
            'barang_id'   => $request->barang_id,
            'harga'      => $harga,
            'jumlah'     => $request->jumlah
        ]);

         // Kurangi stok barang yang terjual
        $stok = StokModel::where('barang_id', $request->barang_id)->latest()->first(); // Ambil entri stok terbaru
        $stok->stok_jumlah -= $request->jumlah; // Kurangi jumlah stok dengan jumlah barang yang terjual
        $stok->save(); // Simpan perubahan jumlah stok

        return redirect('/penjualan')->with('success','Data penjualan berhasil disimpan');
    }

    public function show (string $id){
        $penjualan = penjualanModel::with('user')->find($id);
        $user = UserModel::all();
        $barang = BarangModel::all();
        $detail = DetailPenjualanModel::all();

        $breadcrumb = (object) [
            'title' => 'Detail penjualan',
            'list' => ['Home', 'penjualan', 'Detail']
        ];

        $page =(object) [
            'title' => 'Detail penjualan'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'user'=>$user,'barang'=>$barang, 'detail'=>$detail, 'activeMenu' => $activeMenu]);
    }

//     public function edit(string $id) 
//     {
//         $penjualan = penjualanModel::with('user')->find($id);
//         $user = UserModel::all();
//         $barang = BarangModel::all();
//         $detail = DetailPenjualanModel::all();

//         $breadcrumb = (object)[
//             'title' => 'Edit penjualan',
//             'list' => ['Home', 'penjualan', 'Edit']
//         ];

//         $page = (object) [
//             'title' => 'Edit penjualan'
//         ];

//         $activeMenu = 'penjualan'; //set menu yang sedang aktif
//         return view('penjualan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'user'=>$user,'barang'=>$barang, 'detail'=>$detail, 'activeMenu' => $activeMenu]);
//     }

//     //Menyimpan perubahan data penjualan
// public function update(Request $request, string $id)
// {
//     $request->validate([
//         'penjualan_kode'   => 'required|string|min:3|unique:t_penjualan,penjualan_kode,'. $id .',penjualan_id',
//         'user_id'          => 'required|integer',
//         'pembeli'          => 'required|string|max:100',
//         'penjualan_tanggal'=> 'required|date_format:Y-m-d\TH:i',
//         'barang_id'        => 'required|integer',
//         'jumlah'           => 'required|integer'
//     ]);
//     penjualanModel::find($id)->update([
//         'penjualan_kode'   => $request->penjualan_kode ? ($request->penjualan_kode) : PenjualanModel::find($id)->penjualan_kode,
//         'user_id'          => $request->user_id,
//         'pembeli'          => $request->pembeli,
//         'penjualan_tanggal'=> $request->penjualan_tanggal
//     ]);
    

//     return redirect('/penjualan')->with("success", "Data penjualan berhasil diubah");
// }

    //Menghapus data penjualan
    public function destroy(string $id)
    {
        $check = penjualanModel::find($id);
        if(!$check){ //untuk mengecek apakah data penjualan dengan id yang dimaksud ada atau tidak
        return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
    }
    try {
        // Hapus detail penjualan terlebih dahulu
        DetailPenjualanModel::where('penjualan_id', $id)->delete();
        
        // Hapus data penjualan
        $penjualan = penjualanModel::find($id);
        if (!$penjualan) {
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }
        $penjualan->delete();

        DB::commit();

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
    } catch (\Exception $e) {
        DB::rollback();

        return redirect('/penjualan')->with('error', 'Gagal menghapus data penjualan: ' . $e->getMessage());
    }
    }

}
