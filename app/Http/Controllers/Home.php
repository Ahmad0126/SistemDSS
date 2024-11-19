<?php

namespace App\Http\Controllers;

use App\Models\Baris;
use App\Models\Data;
use App\Models\Kolom;
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
        $data['title'] = 'Tabel '.$data['table']['tabel']->nama;
        return view('tabel', $data);
    }
    public function tambah(Request $req){
        $req->validate([
            'nama' => 'required'
        ]);

        $tabel = new Tabel();
        $tabel->nama = $req->nama;
        $tabel->save();

        return redirect()->back()->with('alert', 'Berhasil menambah tabel');
    }
    public function edit(Request $req){
        $req->validate([
            'nama' => 'required',
            'id' => 'required:tabel,id'
        ]);

        $tabel = Tabel::find($req->id);
        $tabel->nama = $req->nama;
        $tabel->save();

        return redirect()->back()->with('alert', 'Berhasil mengedit tabel');
    }
    public function hapus($id){
        $row = Baris::where('id_tabel', $id)->get();
        $col = Kolom::where('id_tabel', $id)->get();
        foreach($row as $baris){
            $data = Data::where('id_baris', $baris->id)->get();
            Data::destroy($data);
        }
        Baris::destroy($row);
        Kolom::destroy($col);
        Tabel::destroy($id);
        
        return redirect()->back()->with('alert', 'Berhasil menghapus tabel');
    }
}
