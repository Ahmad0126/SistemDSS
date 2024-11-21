<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kolom extends Model
{
    use HasFactory;
    protected $table = 'kolom';

    public function get_urutan($tabel, $force){
        $last_col = DB::table($this->table)
            ->selectRaw("MAX(urutan) as pos")
            ->where('id_tabel', $tabel)->get()->first();

        $urutan = $last_col->pos + 1;
        if($force){
            $cols = DB::table($this->table)->where('id_tabel', $tabel)->where('urutan', '>=', $force)->get();
            if($cols->isNotEmpty()){
                $urutan = $force;
                foreach($cols as $kolom){
                    $old_col = Kolom::find($kolom->id);
                    $old_col->urutan = $old_col->urutan + 1;
                    $old_col->save();
                }
            }
        }

        return $urutan;
    }
    public function edit_urutan($last_urutan, $edit, $id){
        $urutan = $last_urutan;
        if($edit && $last_urutan != $edit){
            $cols = DB::table($this->table)->where('id_tabel', $id)->where('urutan', '>=', $edit)->get();
            if($cols->isNotEmpty()){
                $urutan = $edit;
                foreach($cols as $kolom){
                    $old_col = Kolom::find($kolom->id);
                    $old_col->urutan = $old_col->urutan + 1;
                    $old_col->save();
                }
            }
        }else if(!$edit){
            $last_col = DB::table($this->table)
                ->selectRaw("MAX(urutan) as pos")
                ->where('id_tabel', $id)->get()->first();

            $urutan = $last_col->pos + 1;
        }

        return $urutan;
    }
}
