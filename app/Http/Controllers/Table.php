<?php

namespace App\Http\Controllers;

use App\Models\UserTabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Table extends Controller
{
    public function index(){
        $data['tabel'] = UserTabel::where('id_user', auth()->id())->get();
        $data['title'] = 'Menu Database';
        return view('database', $data);
    }
    public function struktur($id){
        $tabel = UserTabel::find($id);
        if($tabel->id_user != auth()->id()){
            abort(403);
        }
        $kolom = DB::select('show columns from '.$tabel->nama_asli);

        $data['kolom'] = $kolom;
        $data['tabel'] = UserTabel::where('id_user', auth()->id())->get();
        $data['title'] = 'Struktur Tabel '.$tabel->nama;
        return view('struktur', $data);
    }
    public function tabel($id){
        $tabel = UserTabel::find($id);
        if($tabel->id_user != auth()->id()){
            abort(403);
        }
        $tableData = DB::table($tabel->nama_asli)->paginate(25);
        $result = json_decode(json_encode($tableData->items()), true);

        $data['kolom'] = empty($result) ? [] : array_keys($result[0]);
        $data['baris'] = $result;
        $data['id'] = $id;
        $data['page'] = $tableData;
        $data['tabel'] = UserTabel::where('id_user', auth()->id())->get();
        $data['title'] = 'Tabel '.$tabel->nama;
        return view('tabel', $data);
    }

    public function tambah(Request $req){
        $req->validate([
            'nama' => 'required'
        ]);

        return UserTabel::buat_tabel($req->nama, true);
    }
    public function edit(Request $req){
        $req->validate([
            'nama' => 'required',
            'id' => 'required:tabel,id'
        ]);

        return UserTabel::rename_tabel($req->nama, $req->id, true);
    }
    public function hapus($id){
        return UserTabel::drop_tabel($id, true);
    }
}
