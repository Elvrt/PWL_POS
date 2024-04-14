<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\POSController;
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

