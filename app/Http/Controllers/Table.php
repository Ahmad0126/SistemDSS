<?php

namespace App\Http\Controllers;

use App\Models\Baris;
use App\Models\Data;
use App\Models\Kolom;
use App\Models\Tabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Table extends Controller
{
    public function struktur($id){
        $data['kolom'] = Kolom::where('id_tabel', $id)->orderBy('urutan')->get();
        $data['tabel'] = Tabel::find($id);
        $data['title'] = 'Struktur Tabel '.$data['tabel']->nama;
        return view('struktur', $data);
    }

    public function tambah_kolom(Request $req){
        $req->validate([
            'nama' => 'required',
            'id' => 'required:tabel,id'
        ]);

        $kolom = new Kolom();
        $kolom->id_tabel = $req->id;
        $kolom->nama = $req->nama;
        $kolom->urutan = $kolom->get_urutan($req->id, $req->urutan);
        $kolom->save();

        return redirect()->back()->with('alert', 'Berhasil menambah kolom');
    }
    public function edit_kolom(Request $req){
        $req->validate([
            'nama' => 'required',
            'id' => 'required:kolom,id'
        ]);

        $col = new Kolom();
        $kolom = Kolom::find($req->id);
        $kolom->nama = $req->nama;
        $kolom->urutan = $col->edit_urutan($kolom->urutan, $req->urutan, $kolom->id_tabel);
        $kolom->save();

        return redirect()->back()->with('alert', 'Berhasil mengedit kolom');
    }
    public function hapus_kolom(Request $req){
        $req->validate([
            'id' => 'required:kolom,id'
        ]);

        Data::destroy(Data::where('id_kolom', $req->id)->get());
        Kolom::destroy($req->id);
        
        return redirect()->back()->with('alert', 'Berhasil menghapus kolom');
    }

    public function tambah_data(Request $req){
        $col = Kolom::where('id_tabel', $req->id)->get();
        if($col->isEmpty()){
            return redirect()->back()->withErrors('Buat kolom terlebih dahulu');
        }
        $row = new Baris();
        $row->id_tabel = $req->id;
        $row->urutan = $row->get_urutan($req->id);
        $row->save();

        foreach($col as $kolom){
            $data = new Data();
            $data->id_kolom = $kolom->id;
            $data->id_baris = $row->id;
            $data->data = $req[$kolom->id];
            $data->save();
        }
        
        return redirect()->back()->with('alert', 'Berhasil menambah data');
    }
    public function edit_data(Request $req){
        $d = Data::where(['id_baris' => $req->id_baris, 'id_kolom' => $req->id_kolom])->get()->first();
        if($d){
            $data = Data::find($d->id);
        }else{
            $data = new Data();
        }
        $data->id_kolom = $req->id_kolom;
        $data->id_baris = $req->id_baris;
        $data->data = $req->data ?? '';
        $data->save();
        
        return redirect()->back()->with('alert', 'Berhasil nemgedit data');
    }
    public function hapus_data($id){
        Data::destroy(Data::where('id_baris', $id)->get());
        Baris::destroy($id);
        
        return redirect()->back()->with('alert', 'Berhasil menghapus data');
    }

    public function hapus_baris(Request $req){
        $req->validate([
            'from' => 'required'
        ]);

        $baris = Baris::where('id_tabel', $req->id);
        if($req->to){
            $baris->whereBetween('urutan', [$req->from, $req->to])->get();
        }else{
            $baris->where('urutan', $req->from)->get();
        }

        ddd($baris);

        foreach($baris as $b){
            Data::destroy(Data::where('id_baris', $b->id)->get());
        }
        Baris::destroy($baris);
        
        return redirect()->back()->with('alert', 'Berhasil menghapus baris');
    }
    public function tambah_baris(Request $req){
        $req->validate([
            'id' => 'required|exists:tabel,id',
            'jumlah' => 'required|integer'
        ]);
        for($i = 1; $i <= $req->jumlah; $i++){
            $row = new Baris();
            $row->id_tabel = $req->id;
            $row->urutan = $row->get_urutan($req->id, $req->urutan);
            $row->save();
        }
        
        return redirect()->back()->with('alert', 'Berhasil menambah baris');
    }
    public function edit_baris(Request $req){
        $req->validate([
            'id' => 'required|exists:baris,id'
        ]);

        $baris = new Baris();
        $row = Baris::find($req->id);
        $row->urutan = $baris->edit_urutan($row->urutan, $req->urutan, $row->id_tabel);
        $row->save();
        
        return redirect()->back()->with('alert', 'Berhasil memindahkan baris');
    }
}
