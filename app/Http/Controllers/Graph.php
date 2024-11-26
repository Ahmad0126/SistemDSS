<?php

namespace App\Http\Controllers;

use App\Models\Tabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class Graph extends Controller
{
    public function show($id){
        if(!Gate::allows('private_project', $id)){
            abort(403);
        }
        $tabel = new Tabel();
       
        $data = $tabel->get_grafik($id);
        $data['title'] = $data['table']['tabel']->nama;
        
        if($data['table']['tabel']->tipe == 'pie' || $data['table']['tabel']->tipe == 'radar'){
            return view('grafik_pie', $data);
        }else{
            return view('grafik', $data);
        }
    }
    public function simpan(Request $req){
        $req->validate([
            'id' => 'required:tabel,id'
        ]);

        $tabel = Tabel::find($req->id);
        $tabel->tipe = $req->tipe ?? $tabel->tipe;
        $tabel->orientasi = $req->orientasi ?? $tabel->orientasi;
        $tabel->mr = $req->mr ?? $tabel->mr;
        $tabel->ml = $req->ml ?? $tabel->ml;
        $tabel->mt = $req->mt ?? $tabel->mt;
        $tabel->mb = $req->mb ?? $tabel->mb;
        $tabel->max_sumbu = $req->max_sumbu ?? $tabel->max_sumbu;
        $tabel->pie_kolom = $req->pie_kolom ?? $tabel->pie_kolom;
        $tabel->save();

        return redirect()->back()->with('alert', 'Berhasil mengubah pengaturan');
    }
}
