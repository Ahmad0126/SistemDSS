<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserTabel extends Model
{
    use HasFactory;
    protected $table = 'user_tabel';
    private static $system_tables = [
        'failed_jobs',
        'migrations',
        'password_reset_tokens',
        'password_access_tokens',
        'users',
        'user_tabel',
        'user_grafik',
    ];

    public static function buat_tabel($query, $auto = false){
        try{
            if($auto){
                $nama_tabel = $query;
                $new_query = 'create table `user_'.auth()->id().'_'.$nama_tabel.'` (id INT PRIMARY KEY AUTO_INCREMENT)';
            }else{
                $queries = explode(" ", $query);
                if(!isset($queries[2])) return redirect()->back()->withErrors('Invalid Query!')->withInput();
        
                $nama_tabel = $queries[2];
                $new_query = self::modifyQuery($query, $nama_tabel);
            }

            DB::statement($new_query);

            $tabel = new self();
            $tabel->nama = $nama_tabel;
            $tabel->nama_asli = "user_".auth()->id()."_{$nama_tabel}";
            $tabel->id_user = auth()->id();
            $tabel->save();

            return redirect()->back()->with('alert', 'Query berhasil dijalankan')->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('query_error', $e->getMessage())->withInput();
        }
    }
    public static function rename_tabel($query, $id = null, $auto = false){
        try{
            if($auto && $id){
                $tabel = self::find($id);
                if($tabel->id_user != auth()->id()){
                    abort(403);
                }
                $new_tabel = $query;
                $new_query = "ALTER TABLE `{$tabel->nama_asli}` RENAME `user_".auth()->id()."_{$new_tabel}`";
            }else{
                $queries = explode(" ", $query);
                if(!isset($queries[2])) return redirect()->back()->withErrors('Invalid Query!')->withInput();
        
                $nama_tabel = $queries[2];
                $table = self::where(['id_user' => auth()->id(), 'nama' => $nama_tabel])->get()->first();
                $tabel = self::find($table->id);
                $new_query = self::modifyQuery($query, $nama_tabel);
        
                $new_tabel = $table->nama;
                if(preg_match('/\brename\b(?!\s+column)/i', $query)){
                    $new_tabel = $queries[count($queries) - 1];
                    $new_query = self::modifyQuery($new_query, $new_tabel);
                }
            }

            DB::statement($new_query);

            $tabel->nama = $new_tabel;
            $tabel->nama_asli = "user_".auth()->id()."_{$new_tabel}";
            $tabel->id_user = auth()->id();
            $tabel->save();

            return redirect()->back()->with('alert', 'Query berhasil dijalankan')->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('query_error', $e->getMessage())->withInput();
        }
    }
    public static function drop_tabel($query, $auto = false){
        try{
            if($auto){
                $table = self::find($query);
                if($table->id_user != auth()->id()){
                    abort(403);
                }
                $new_query = "DROP TABLE `{$table->nama_asli}`";
            }else{
                $queries = explode(" ", $query);
                if(!isset($queries[2])) return redirect()->back()->withErrors('Invalid Query!')->withInput();
        
                $nama_tabel = $queries[2];
                $table = UserTabel::where(['id_user' => auth()->id(), 'nama' => $nama_tabel])->get()->first();
                $new_query = self::modifyQuery($query, $nama_tabel);
            }

            DB::statement($new_query);
            UserTabel::destroy($table->id);

            return redirect()->back()->with('alert', 'Query berhasil dijalankan')->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('query_error', $e->getMessage())->withInput();
        }
    }

    public static function modifyQuery($query, $nama_tabel = null, $user_id = null){
        $qu = $query;
        $sama = 0;
        $id_user = $user_id ?? auth()->id();
        $exception = new \Exception('Tidak boleh menggunakan nama tabel sebagai nama kolom atau alias!');
        if($nama_tabel){
            $sama = preg_match_all('/\b'.$nama_tabel.'\b(?!\.)/', $query);
            $qu = str_replace($nama_tabel, "user_{$id_user}_{$nama_tabel}", $query);
            if($sama > 1){ throw $exception; }
        }else{
            $tabel = UserTabel::where('id_user', $id_user)->get();
            foreach($tabel as $t){
                $sama = preg_match_all('/\b'.$t->nama.'\b(?!\.)/', $query);
                $qu = str_replace($t->nama, $t->nama_asli, $qu);
                if($sama > 1){ throw $exception; }
            }
        }
        if($qu == $query){
            //cek apakah user mengakses system table
            foreach(self::$system_tables as $t){
                $sama = preg_match_all('/'.$t.'/', $query);
                $qu = str_replace(" {$t}", " user_{$id_user}_{$t}", $query);
                if($sama > 1){ throw $exception; }
            }
            //cek apakah user mengakses tabel user lain
            $qu = preg_replace_callback('/(user_\d+)/', function($matches) use($id_user) {
                return "user_{$id_user}_" . $matches[0]; // Tambahkan "$_" di awal
            }, $query);
        }

        return $qu;
    }
}
