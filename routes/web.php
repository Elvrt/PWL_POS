<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\barangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\penjualanController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\stokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Database\Seeders\KategoriSeeder;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/level', [LevelController::class, 'index']);

Route::get('/user', [UserController::class,'index']);

Route::get('/user/tambah', [UserController::class,'tambah']);
Route::post('/user/tambah_simpan', [UserController::class,'tambah_simpan']);
Route::get('/user/ubah/{id}', [UserController::class,'ubah']);
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
Route::get('/user/hapus/{id}', [UserController::class,'hapus']);

// Route::get('/kategori', [KategoriController::class,'index']);

Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

Route::get('/kategori/create', [KategoriController::class,'create']);

Route::post('/kategori', [KategoriController::class,'store']);

Route::get('/kategori/delete/{id}', [KategoriController::class, 'delete'])->name('kategori.delete');

Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');

Route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');


Route::get('/level/tambah', [LevelController::class,'tambah']);

Route::resource('m_user', POSController::class);

Route::get('/', [WelcomeController::class,'index']);

Route::group(['prefix' => 'user'], function (){
    Route::get('/', [UserController::class, 'index']);//halaman awal user   
    Route::post('/list', [UserController::class , 'list']);//halaman data user dalam bentuk json
    Route::get('/create', [UserController::class , 'create']);//halaman form tambah user
    Route::post('/', [UserController::class , 'store']);//menyimpan data user baru             
    Route::get('/{id}', [UserController::class, 'show'])->name('user.show');//menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);// menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']); // menampilkan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']);// menghapus data user
});


// level
Route::group(['prefix' => 'level'], function (){
    Route::get('/', [LevelController::class, 'index']);//halaman awal user   
    Route::post('/list', [LevelController::class , 'list']);//halaman data user dalam bentuk json
    Route::get('/create', [LevelController::class , 'create']);//halaman form tambah user
    Route::post('/',[LevelController::class , 'store']);//menyimpan data user baru             
    Route::get('/{id}', [LevelController::class, 'show'])->name('level.show');//menampilkan detail user
    Route::get('/{id}/edit', [LevelController::class, 'edit']);// menampilkan halaman form edit user
    Route::put('/{id}', [LevelController::class, 'update']); // menampilkan perubahan data user
    Route::delete('/{id}', [LevelController::class, 'destroy']);// menghapus data user
});

// kategori
Route::group(['prefix' => 'kategori'], function (){
    Route::get('/', [KategoriController::class, 'index']);//halaman awal user   
    Route::post('/list', [KategoriController::class , 'list']);//halaman data user dalam bentuk json
    Route::get('/create', [KategoriController::class , 'create']);//halaman form tambah user
    Route::post('/',[KategoriController::class , 'store']);//menyimpan data user baru             
    Route::get('/{id}', [KategoriController::class, 'show'])->name('kategori.show');//menampilkan detail user
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);// menampilkan halaman form edit user
    Route::put('/{id}', [KategoriController::class, 'update']); // menampilkan perubahan data user
    Route::delete('/{id}', [KategoriController::class, 'destroy']);// menghapus data user
});


// Barang
Route::group(['prefix' => 'barang'], function (){
    Route::get('/', [BarangController::class, 'index']);//halaman awal user   
    Route::post('/list', [BarangController::class , 'list']);//halaman data user dalam bentuk json
    Route::get('/create', [BarangController::class , 'create']);//halaman form tambah user
    Route::post('/',[BarangController::class , 'store']);//menyimpan data user baru             
    Route::get('/{id}', [BarangController::class, 'show'])->name('barang.show');//menampilkan detail user
    Route::get('/{id}/edit', [BarangController::class, 'edit']);// menampilkan halaman form edit user
    Route::put('/{id}', [BarangController::class, 'update']); // menampilkan perubahan data user
    Route::delete('/{id}', [BarangController::class, 'destroy']);// menghapus data user
});

//stok

Route::group(['prefix' => 'stok'], function (){
    Route::get('/', [StokController::class, 'index']);//halaman awal user   
    Route::post('/list', [StokController::class , 'list']);//halaman data user dalam bentuk json
    Route::get('/create', [StokController::class , 'create']);//halaman form tambah user
    Route::post('/',[StokController::class , 'store']);//menyimpan data user baru             
    Route::get('/{id}', [StokController::class, 'show'])->name('stok.show');//menampilkan detail user
    Route::get('/{id}/edit', [StokController::class, 'edit']);// menampilkan halaman form edit user
    Route::put('/{id}', [StokController::class, 'update']); // menampilkan perubahan data user
    Route::delete('/{id}', [StokController::class, 'destroy']);// menghapus data user
});

//penjualan
Route::group(['prefix' => 'penjualan'], function (){
    Route::get('/', [PenjualanController::class, 'index']);//halaman awal user   
    Route::post('/list', [PenjualanController::class , 'list']);//halaman data user dalam bentuk json
    Route::get('/create', [PenjualanController::class , 'create']);//halaman form tambah user
    Route::post('/',[PenjualanController::class , 'store']);//menyimpan data user baru             
    Route::get('/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');//menampilkan detail user
    Route::get('/{id}/edit', [PenjualanController::class, 'edit']);// menampilkan halaman form edit user
    Route::put('/{id}', [PenjualanController::class, 'update']); // menampilkan perubahan data user
    Route::delete('/{id}', [PenjualanController::class, 'destroy']);// menghapus data user
});

//kita atur juga untuk middleware menggunakan grup pada routing
//di dalamnta terdapat grup untuk mengecek kondisi login
// jika user yang login merupakan admin maka akan diarahkan ke AdminController
//jika user yang login merupakan manager maka akan diarahkan ke Usercontroller

Route::get('login', [Authcontroller::class, 'index'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('proses_register', [AuthController::class, 'proses_register'])->name('proses_register');

Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => ['cek_login:1']], function () {
        Route::resource('admin', AdminController::class);
    });
    Route::group(['middleware' => ['cek_login:2']], function () {
        Route::resource('manager', ManagerController::class);
    });
});

