<?php

use App\Http\Controllers\Home;
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

Route::get('/', [Home::class, 'index']);
Route::get('/tabel/{id}', [Home::class, 'tabel'])->name('tabel');
Route::get('/hapus/{id}', [Home::class, 'hapus'])->name('hapus_tabel');
Route::post('/tambah', [Home::class, 'tambah'])->name('tambah_tabel');
Route::post('/edit', [Home::class, 'edit'])->name('edit_tabel');
Route::get('reactor/', function () {
    return Inertia::render('Home', ['title' => 'Dashboard']);
});
