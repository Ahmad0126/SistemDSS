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
        'tabel',
        'kolom',
        'baris',
        'data'
    ];

    public static function buat_tabel($query, $auto = false){
        if($auto){
            $nama_tabel = $query;
            $new_query = 'create table user_'.auth()->id().'_'.$nama_tabel.' (id INT PRIMARY KEY AUTO_INCREMENT)';
        }else{
            $queries = explode(" ", $query);
            if(!isset($queries[2])) return redirect()->back()->withErrors('Invalid Query!')->withInput();
    
            $nama_tabel = $queries[2];
            $new_query = self::modifyQuery($query, $nama_tabel);
        }

        try{
            DB::statement($new_query);

            $tabel = new self();
            $tabel->nama = $nama_tabel;
            $tabel->nama_asli = "user_".auth()->id()."_{$nama_tabel}";
            $tabel->id_user = auth()->id();
            $tabel->save();

            return redirect()->back()->with('alert', 'Query berhasil dijalankan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
    public static function rename_tabel($query, $id = null, $auto = false){
        if($auto && $id){
            $tabel = self::find($id);
            $new_tabel = $query;
            $new_query = "ALTER TABLE {$tabel->nama_asli} RENAME user_".auth()->id()."_{$new_tabel}";
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

        try{
            DB::statement($new_query);

            $tabel->nama = $new_tabel;
            $tabel->nama_asli = "user_".auth()->id()."_{$new_tabel}";
            $tabel->id_user = auth()->id();
            $tabel->save();

            return redirect()->back()->with('alert', 'Query berhasil dijalankan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
    public static function drop_tabel($query, $auto = false){
        if($auto){
            $table = self::find($query);
            $new_query = "DROP TABLE {$table->nama_asli}";
        }else{
            $queries = explode(" ", $query);
            if(!isset($queries[2])) return redirect()->back()->withErrors('Invalid Query!')->withInput();
    
            $nama_tabel = $queries[2];
            $table = UserTabel::where(['id_user' => auth()->id(), 'nama' => $nama_tabel])->get()->first();
            $new_query = self::modifyQuery($query, $nama_tabel);
        }

        try{
            DB::statement($new_query);
            UserTabel::destroy($table->id);

            return redirect()->back()->with('alert', 'Query berhasil dijalankan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public static function modifyQuery($query, $nama_tabel = null){
        if($nama_tabel){
            $qu = str_replace(" {$nama_tabel}", " user_".auth()->id()."_{$nama_tabel}", $query);
        }else{
            $tabel = UserTabel::where('id_user', auth()->id())->get();
            foreach($tabel as $t){
                $qu = str_replace(" {$t->nama}", " {$t->nama_asli}", $query);
                if($qu != $query){ break; }
            }
        }
        if($qu == $query){
            //cek apakah user mengakses system table
            foreach(self::$system_tables as $t){
                $qu = str_replace(" {$t}", " user_".auth()->id()."_{$t}", $query);
                if($qu != $query){ break; }
            }
        }

        return $qu;
    }
}
