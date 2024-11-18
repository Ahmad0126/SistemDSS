<?php

namespace App\Http\Controllers;

use App\Models\Tabel;
use Illuminate\Http\Request;

class Home extends Controller
{
    public function index(){
        $data['tabel'] = Tabel::all();
        $data['title'] = 'Dashboard';
        return view('home', $data);
    }
    public function tabel($id){
        $tabel = new Tabel();
        $data['table'] = $tabel->getData($id);
        $data['title'] = 'Tabel Anda';
        return view('tabel', $data);
    }
    public function tambah(Request $req){
        // $req->validate([
        //     'nama' => 'required|unique:nama,nama'
        // ]);

        $tabel = new Tabel();
        $tabel->nama = $req->nama;
        $tabel->save();

        return redirect()->back()->with('alert', 'Berhasil menambah tabel');
    }
    public function edit(Request $req){
        // $req->validate([
        //     'nama' => 'required|unique:nama,nama,'.$req->id.',id',
        //     'id' => 'required:nama,id'
        // ]);

        $tabel = Tabel::find($req->id);
        $tabel->nama = $req->nama;
        $tabel->save();

        return redirect()->back()->with('alert', 'Berhasil mengedit tabel');
    }
    public function hapus($id){
        Tabel::destroy($id);
        
        return redirect()->back()->with('alert', 'Berhasil menghapus tabel');
    }
}
