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
        if($force){
            $rows = DB::table($this->table)->where('id_tabel', $tabel)->where('urutan', '>=', $force)->get();
            if($rows->isNotEmpty()){
                $urutan = $force;
                foreach($rows as $baris){
                    $old_row = Baris::find($baris->id);
                    $old_row->urutan = $old_row->urutan + 1;
                    $old_row->save();
                }
            }
        }

        return $urutan;
    }
    public function edit_urutan($last_urutan, $edit, $id){
        $urutan = $last_urutan;
        if($edit && $last_urutan != $edit){
            $rows = DB::table($this->table)->where('id_tabel', $id)->where('urutan', '>=', $edit)->get();
            if($rows->isNotEmpty()){
                $urutan = $edit;
                foreach($rows as $baris){
                    $old_row = Baris::find($baris->id);
                    $old_row->urutan = $old_row->urutan + 1;
                    $old_row->save();
                }
            }
        }else if(!$edit){
            $last_row = DB::table($this->table)
                ->selectRaw("MAX(urutan) as pos")
                ->where('id_tabel', $id)->get()->first();

            $urutan = $last_row->pos + 1;
        }

        return $urutan;
    }
    public function urutkan($id_tabel, $id_kolom, $urutan){
        $data = DB::table($this->table, 'b')
            ->select('b.id')
            ->leftJoin(DB::raw('data d'), 'd.id_baris', '=', DB::raw('b.id AND d.id_kolom = '.$id_kolom))
            ->where('id_tabel', $id_tabel)
            ->orderBy(DB::raw('d.data'), $urutan)->get();
        
        $n = 1;
        foreach($data as $row){
            $baris = self::find($row->id);
            $baris->urutan = $n++;
            $baris->save();
        }
    }
}
