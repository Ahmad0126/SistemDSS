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

// Route::get('/', [Home::class, 'index'])->name('home');
Route::get('/', function(){
    return view('welcome');
})->name('home');
Route::get('/grafik/public/{id}', [Graph::class, 'tampilkan'])->name('show_grafik');
Route::get('/grafik/thumbnail/{id}', [Graph::class, 'thumbnail'])->name('thumbnail_grafik');
Route::get('/project/search', [Home::class, 'search'])->name('search');
Route::get('/project/{id}', [Home::class, 'project'])->name('project');

Route::middleware('guest')->group(function(){
    Route::get('/login', function(){ return view('login'); })->name('masuk');
    Route::get('/daftar', function(){ return view('daftar'); })->name('daftar');
    Route::post('/login', [Home::class, 'login'])->name('login');
    Route::post('/daftar', [Home::class, 'daftar'])->name('register');
});

Route::middleware('auth')->group(function(){
    Route::get('/home', [Home::class, 'home'])->name('base');
    Route::get('/password', function(){
        return view('ganti_password');
    })->name('change_password');
    Route::post('/logout', [Home::class, 'logout'])->name('logout');
    Route::post('/ganti_password', [Home::class, 'ganti_password'])->name('ganti_password');

    Route::get('/mydatabase', [Table::class, 'index'])->name('database');
    Route::get('/mydatabase/hapus/{id}', [Table::class, 'hapus'])->name('hapus_tabel');
    Route::post('/mydatabase/tambah', [Table::class, 'tambah'])->name('tambah_tabel');
    Route::post('/mydatabase/edit', [Table::class, 'edit'])->name('edit_tabel');

    Route::get('/query', [Query::class, 'index'])->name('query');
    Route::get('/query/result', [Query::class, 'result'])->name('result_query');
    Route::post('/query/run', [Query::class, 'execute'])->name('run_query');
    
    Route::middleware('can:admin')->group(function(){
        Route::get('/user', [User::class, 'index'])->name('user');
        Route::post('/user/tambah', [User::class, 'tambah'])->name('tambah_user');
        Route::post('/user/edit', [User::class, 'edit'])->name('edit_user');
        Route::get('/user/hapus/{id}', [User::class, 'hapus'])->name('hapus_user');
    });
    
    Route::get('/tabel/{id}', [Table::class, 'tabel'])->name('tabel');
    Route::get('/tabel/struktur/{id}', [Table::class, 'struktur'])->name('struktur');
    
    Route::get('/grafik', [Graph::class, 'index'])->name('daftar_grafik');
    Route::get('/grafik/search', [Home::class, 'search_mine'])->name('search_mine');
    Route::get('/grafik/{id}', [Graph::class, 'show'])->name('grafik');
    Route::post('/grafik/simpan', [Graph::class, 'simpan'])->name('simpan_grafik');
    Route::post('/grafik/tambah', [Graph::class, 'tambah'])->name('tambah_grafik');
    Route::post('/grafik/edit', [Graph::class, 'edit'])->name('edit_grafik');
    Route::post('/grafik/publish', [Graph::class, 'publish'])->name('publish_grafik');
    Route::get('/grafik/hapus/{id}', [Graph::class, 'hapus'])->name('hapus_grafik');
    Route::get('/grafik/unpublish/{id}', [Graph::class, 'unpublish'])->name('unpublish_grafik');
});

Route::get('reactor/', function () {
    return Inertia::render('Home', ['title' => 'Dashboard']);
});
