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
        $table = $tabel->getData($id);

        $baris = $table['baris'];
        $kolom = $table['kolom'];
        $t_data = $table['data'];

        $first_kolom = array_slice($kolom, 0, 1);
        $rest_kolom = array_slice($kolom, 1);
        $g_data = [];
        $series = [];
        //make g_data
        foreach($baris as $r){
            array_push($g_data, $t_data[$r->id][$first_kolom[0]->nama] ?? []);
        }
        //make series
        foreach($rest_kolom as $k){
            $s_data = [];
            foreach($baris as $r){
                array_push($s_data, $t_data[$r->id][$k->nama] ?? '');
            }
            array_push($series, [
                'name' => $k->nama,
                'type' => $table['tabel']->tipe,
                'data' => $s_data
            ]);
        }
        
        $data['data'] = $g_data;
        $data['series'] = $series;
        $data['table'] = $table;
        $data['title'] = $data['table']['tabel']->nama;
        return view('grafik', $data);
    }
    public function simpan(Request $req){
        $req->validate([
            'orientasi' => 'required',
            'tipe' => 'required',
            'id' => 'required:tabel,id'
        ]);

        $tabel = Tabel::find($req->id);
        $tabel->tipe = $req->tipe;
        $tabel->orientasi = $req->orientasi;
        $tabel->mr = $req->mr;
        $tabel->ml = $req->ml;
        $tabel->mt = $req->mt;
        $tabel->mb = $req->mb;
        $tabel->save();

        return redirect()->back()->with('alert', 'Berhasil mengubah pengaturan');
    }
}
