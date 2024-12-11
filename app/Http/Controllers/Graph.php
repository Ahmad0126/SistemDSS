<?php

namespace App\Http\Controllers;

use App\Models\UserTabel;
use App\Models\UserGrafik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class Graph extends Controller
{
    public function index(){
        $data['grafik'] = UserGrafik::where('id_user', auth()->id())->get();
        $data['title'] = 'Daftar Grafik';
        return view('daftar_grafik', $data);
    }
    public function show($id){
        $grafik = UserGrafik::find($id);
        if($grafik->id_user != auth()->id()){
            abort(403);
        }
        $data['query_error'] = null;
        try {
            $result = [];
            if($grafik->query){
                $result = DB::select(UserTabel::modifyQuery($grafik->query));
                $result = json_decode(json_encode($result), true);
            }

            $data['kolom'] = empty($result) ? [] : array_keys($result[0]);
            $data['baris'] = $result;
        } catch (\Exception $e) {
            $data['query_error'] = $e->getMessage();
        }

        $data['grafik'] = $grafik;
        $data['title'] = 'Grafik '.$grafik->judul;
        return view('grafik', $data);
    }

    public function tambah(Request $req){
        $req->validate([
            'judul' => 'required',
            'tipe' => 'required',
        ]);

        $grafik = new UserGrafik();
        $grafik->id_user = auth()->id();
        $grafik->judul = $req->judul;
        $grafik->tipe = $req->tipe;
        $grafik->query = $req->input('query');
        $grafik->orientasi = $req->orientasi ?? 'h';
        $grafik->mr = $req->mr ?? '10';
        $grafik->ml = $req->ml ?? '10';
        $grafik->mt = $req->mt ?? '16';
        $grafik->mb = $req->mb ?? '6';
        $grafik->save();

        $redirect = $req->input('query') ? redirect(route('grafik', $grafik->id)) : redirect()->back();
        return $redirect->with('alert', 'Berhasil membuat grafik');
    }
    public function edit(Request $req){
        $req->validate([
            'id' => 'required',
            'judul' => 'required',
            'tipe' => 'required',
        ]);

        $grafik = UserGrafik::find($req->id);
        if($grafik->id_user != auth()->id()){
            return redirect()->back()->withErrors('Grafik ini Bukan Punyamu');
        }
        $grafik->judul = $req->judul;
        $grafik->tipe = $req->tipe;
        $grafik->save();

        return redirect()->back()->with('alert', 'Berhasil mengedit grafik');
    }
    public function hapus($id){
        $grafik = UserGrafik::find($id);
        if($grafik->id_user != auth()->id()){
            abort(403);
        }
        UserGrafik::destroy($id);
        
        return redirect()->back()->with('alert', 'Berhasil menghapus grafik');
    }
    public function simpan(Request $req){
        $req->validate([
            'id' => 'required:user_grafik,id'
        ]);

        $grafik = UserGrafik::find($req->id);
        if($grafik->id_user != auth()->id()){
            return redirect()->back()->withErrors('Grafik ini Bukan Punyamu');
        }
        $query = $req->input('query');
        if($query){
            if(!(mb_stripos($query, 'select') === 0)){
                return redirect()->back()->withErrors('Hanya boleh memasukkan query SELECT');
            }
            $grafik->query = $req->input('query');
        }
        $grafik->tipe = $req->tipe ?? $grafik->tipe;
        $grafik->orientasi = $req->orientasi ?? $grafik->orientasi;
        $grafik->mr = $req->mr ?? $grafik->mr;
        $grafik->ml = $req->ml ?? $grafik->ml;
        $grafik->mt = $req->mt ?? $grafik->mt;
        $grafik->mb = $req->mb ?? $grafik->mb;
        $grafik->max_sumbu = $req->max_sumbu ?? $grafik->max_sumbu;
        $grafik->pie_kolom = $req->pie_kolom ?? $grafik->pie_kolom;
        $grafik->save();

        return redirect()->back()->with('alert', 'Berhasil mengubah pengaturan');
    }
}
