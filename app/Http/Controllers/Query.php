<?php

namespace App\Http\Controllers;

use App\Models\UserTabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Query extends Controller
{
    public function index(){
        $data['tabel'] = UserTabel::where('id_user', auth()->id())->get();
        $data['title'] = 'Run a Query';
        return view('query_input', $data);
    }
    public function result(){
        try {
            $result = null;
            if(session('query')){
                $result = DB::select(UserTabel::modifyQuery(session('query')));
                $result = json_decode(json_encode($result), true);
                session()->flash('alert', 'Query berhasil dijalankan');
            }else{
                session()->flash('error', "Masukkan query terlebih dahulu");
            }

            $data['kolom'] = empty($result) ? [] : array_keys($result[0]);
            $data['baris'] = $result;
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        $data['tabel'] = UserTabel::where('id_user', auth()->id())->get();
        $data['title'] = 'Hasil Query';
        return view('hasil_query', $data);
    }
    public function execute(Request $req){
        $req->validate([
            'query' => 'required|string',
        ]);

        $query = $req->input('query');
        $check = $this->isAllowed($query);
        if($check['status']){
            switch ($check['state']) {
                case 'create table':
                    return UserTabel::buat_tabel($query);
                    break;
                
                case 'alter table':
                    return UserTabel::rename_tabel($query);
                    break;
                
                case 'drop table':
                    return UserTabel::drop_tabel($query);
                    break;
                
                case 'select':
                    session(['query' => $query]);
                    return redirect(route('result_query'));
                    break;
                
                default:
                    try {
                        // Jalankan query
                        DB::statement(UserTabel::modifyQuery($query));
            
                        return redirect()->back()->with('alert', "Query berhasil dijalankan. Cek di halaman database atau tabel");
                    } catch (\Exception $e) {
                        return redirect()->back()->withErrors($e->getMessage())->withInput();
                    }
                break;
            }
        }else{
            return redirect()->back()->withErrors("Query tersebut tidak diizinkan!")->withInput();
        }

    }

    private function isAllowed($query){
        $allowed_query = [
            'select',
            'insert',
            'update',
            'delete',
            'create table',
            'alter table',
            'drop table'
        ];

        $startsWith = false;
        $state = '';

        foreach ($allowed_query as $prefix) {
            if (mb_stripos($query, $prefix) === 0) { // Periksa apakah awalan ditemukan di posisi 0
                $startsWith = true;
                $state = $prefix;
                break;
            }
        }
        return [
            'status' => $startsWith,
            'state' => $state
        ];
    }
}
