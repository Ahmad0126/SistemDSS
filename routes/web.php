<?php

use App\Http\Controllers\Graph;
use App\Http\Controllers\Home;
use App\Http\Controllers\Table;
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

Route::get('/', [Home::class, 'index'])->name('base');
Route::get('/hapus/{id}', [Home::class, 'hapus'])->name('hapus_tabel');
Route::post('/tambah', [Home::class, 'tambah'])->name('tambah_tabel');
Route::post('/edit', [Home::class, 'edit'])->name('edit_tabel');

Route::get('/tabel/{id}', [Home::class, 'tabel'])->name('tabel');
Route::post('/tabel/tambah', [Table::class, 'tambah_data'])->name('tambah_data');
Route::post('/tabel/edit', [Table::class, 'edit_data'])->name('edit_data');
Route::get('/tabel/hapus/{id}', [Table::class, 'hapus_data'])->name('hapus_data');

Route::get('/struktur/{id}', [Table::class, 'struktur'])->name('struktur');
Route::post('/struktur/tambah', [Table::class, 'tambah_kolom'])->name('tambah_kolom');
Route::post('/struktur/edit', [Table::class, 'edit_kolom'])->name('edit_kolom');
Route::get('/struktur/hapus/{id}', [Table::class, 'hapus_kolom'])->name('hapus_kolom');

Route::get('/grafik/{id}', [Graph::class, 'show'])->name('grafik');

Route::get('reactor/', function () {
    return Inertia::render('Home', ['title' => 'Dashboard']);
});
