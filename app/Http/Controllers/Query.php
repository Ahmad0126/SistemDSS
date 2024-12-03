<?php

namespace App\Http\Controllers;

use App\Models\UserTabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Query extends Controller
{
    public function index(){
        return view('query_input', ['title' => 'run a query']);
    }
    public function result(){
        $result = DB::select(session('query'));
        $data['kolom'] = empty($result) ? [] : array_keys(get_object_vars($result[0]));
        $data['baris'] = ($result); //error
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
                    return $this->buat_tabel($query);
                    break;
                
                case 'alter table':
                    return $this->alter_tabel($query);
                    break;
                
                case 'drop table':
                    return $this->drop_tabel($query);
                    break;
                
                case 'select':
                    session(['query' => $this->modifyQuery($query)]);
                    return redirect(route('result_query'));
                    break;
                
                default:
                    try {
                        // Jalankan query
                        DB::statement($this->modifyQuery($query));
            
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

    private function buat_tabel($query){
        $queries = explode(" ", $query);
        if(!isset($queries[2])) return redirect()->back()->withErrors('Invalid Query!')->withInput();

        $nama_tabel = $queries[2];
        $new_query = $this->modifyQuery($query, $nama_tabel);

        try{
            DB::statement($new_query);

            $tabel = new UserTabel();
            $tabel->nama = $nama_tabel;
            $tabel->nama_asli = "user_".auth()->id()."_{$nama_tabel}";
            $tabel->id_user = auth()->id();
            $tabel->save();

            return redirect()->back()->with('alert', 'Query berhasil dijalankan. Cek di halaman database atau tabel');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
    private function alter_tabel($query){
        $queries = explode(" ", $query);
        if(!isset($queries[2])) return redirect()->back()->withErrors('Invalid Query!')->withInput();

        $nama_tabel = $queries[2];
        $table = UserTabel::where(['id_user' => auth()->id(), 'nama' => $nama_tabel])->get()->first();
        $new_query = $this->modifyQuery($query, $nama_tabel);

        $new_tabel = $table->nama;
        if(preg_match('/\brename\b(?!\s+column)/i', $query)){
            $new_tabel = $queries[count($queries) - 1];
            $new_query = $this->modifyQuery($new_query, $new_tabel);
        }

        try{
            DB::statement($new_query);

            $tabel = UserTabel::find($table->id);
            $tabel->nama = $new_tabel;
            $tabel->nama_asli = "user_".auth()->id()."_{$new_tabel}";
            $tabel->id_user = auth()->id();
            $tabel->save();

            return redirect()->back()->with('alert', 'Query berhasil dijalankan. Cek di halaman database atau tabel');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
    private function drop_tabel($query){
        $queries = explode(" ", $query);
        if(!isset($queries[2])) return redirect()->back()->withErrors('Invalid Query!')->withInput();

        $nama_tabel = $queries[2];
        $table = UserTabel::where(['id_user' => auth()->id(), 'nama' => $nama_tabel])->get()->first();
        $new_query = $this->modifyQuery($query, $nama_tabel);

        try{
            DB::statement($new_query);
            UserTabel::destroy($table->id);

            return redirect()->back()->with('alert', 'Query berhasil dijalankan. Cek di halaman database atau tabel');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
    private function modifyQuery($query, $nama_tabel = null){
        if($nama_tabel){
            $qu = str_replace(" {$nama_tabel}", " user_".auth()->id()."_{$nama_tabel}", $query);
        }else{
            $tabel = UserTabel::where('id_user', auth()->id())->get();
            foreach($tabel as $t){
                $qu = str_replace(" {$t->nama}", " {$t->nama_asli}", $query);
                if($qu != $query){ break; }
            }
        }

        return $qu;
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
