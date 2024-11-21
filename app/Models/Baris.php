<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Baris extends Model
{
    use HasFactory;
    protected $table = 'baris';

    public function get_urutan($tabel, $force = null){
        $last_col = DB::table($this->table)
            ->selectRaw("MAX(urutan) as pos")
            ->where('id_tabel', $tabel)->get()->first();

        $urutan = $last_col->pos + 1;
        // if($force){
        //     $rows = DB::table($this->table)->where('id_tabel', $tabel)->where('urutan', '>=', $force)->get();
        //     if($rows->isNotEmpty()){
        //         $urutan = $force;
        //         foreach($rows as $baris){
        //             $old_col = Baris::find($baris->id);
        //             $old_col->urutan = $old_col->urutan + 1;
        //             $old_col->save();
        //         }
        //     }
        // }

        return $urutan;
    }
}
