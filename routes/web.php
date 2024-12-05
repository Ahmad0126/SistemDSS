<?php

use App\Http\Controllers\Graph;
use App\Http\Controllers\Home;
use App\Http\Controllers\Query;
use App\Http\Controllers\Table;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware('guest')->group(function(){
    Route::get('/login', function(){ return view('login'); })->name('masuk');
    Route::get('/daftar', function(){ return view('daftar'); })->name('daftar');
    Route::post('/login', [Home::class, 'login'])->name('login');
    Route::post('/daftar', [Home::class, 'daftar'])->name('register');
});

Route::middleware('auth')->group(function(){
    Route::get('/', [Home::class, 'index'])->name('base');
    Route::get('/password', function(){
        return view('ganti_password');
    })->name('change_password');
    Route::post('/logout', [Home::class, 'logout'])->name('logout');
    Route::post('/ganti_password', [Home::class, 'ganti_password'])->name('ganti_password');

    Route::get('/mydatabase', [Table::class, 'index'])->name('database');
    Route::get('/mydatabase/hapus/{id}', [Home::class, 'hapus'])->name('hapus_tabel');
    Route::post('/mydatabase/tambah', [Home::class, 'tambah'])->name('tambah_tabel');
    Route::post('/mydatabase/edit', [Home::class, 'edit'])->name('edit_tabel');

    Route::get('/query', [Query::class, 'index'])->name('query');
    Route::get('/query/result', [Query::class, 'result'])->name('result_query');
    Route::post('/query/run', [Query::class, 'execute'])->name('run_query');
    
    Route::middleware('can:admin')->group(function(){
        Route::get('/user', [User::class, 'index'])->name('user');
        Route::post('/user/tambah', [User::class, 'tambah'])->name('tambah_user');
        Route::post('/user/edit', [User::class, 'edit'])->name('edit_user');
        Route::get('/user/hapus/{id}', [User::class, 'hapus'])->name('hapus_user');
    });
    
    Route::get('/tabel/{id}', [Home::class, 'tabel'])->name('tabel');
    Route::post('/tabel/tambah', [Table::class, 'tambah_data'])->name('tambah_data');
    Route::post('/tabel/edit', [Table::class, 'edit_data'])->name('edit_data');
    Route::get('/tabel/hapus/{id}', [Table::class, 'hapus_data'])->name('hapus_data');
    
    Route::post('/baris/tambah', [Table::class, 'tambah_baris'])->name('tambah_baris');
    Route::post('/baris/edit', [Table::class, 'edit_baris'])->name('edit_baris');
    Route::post('/baris/hapus', [Table::class, 'hapus_baris'])->name('hapus_baris');

    Route::get('/struktur/{id}', [Table::class, 'struktur'])->name('struktur');
    Route::post('/struktur/tambah', [Table::class, 'tambah_kolom'])->name('tambah_kolom');
    Route::post('/struktur/edit', [Table::class, 'edit_kolom'])->name('edit_kolom');
    Route::post('/struktur/hapus/', [Table::class, 'hapus_kolom'])->name('hapus_kolom');
    
    Route::get('/grafik', [Graph::class, 'index'])->name('daftar_grafik');
    Route::get('/grafik/{id}', [Graph::class, 'show'])->name('grafik');
    Route::post('/grafik/simpan', [Graph::class, 'simpan'])->name('simpan_grafik');
    Route::post('/grafik/urutkan', [Graph::class, 'urutkan'])->name('urutkan_grafik');
    Route::post('/grafik/query', [Graph::class, 'query'])->name('query_grafik');
    Route::post('/grafik/tambah', [Graph::class, 'tambah'])->name('tambah_grafik');
    Route::post('/grafik/edit', [Graph::class, 'edit'])->name('edit_grafik');
    Route::get('/grafik/hapus/{id}', [Graph::class, 'hapus'])->name('hapus_grafik');
});

Route::get('reactor/', function () {
    return Inertia::render('Home', ['title' => 'Dashboard']);
});
