<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tabel extends Model
{
    use HasFactory;
    protected  $table = 'tabel';

    public function getData($id){
        $tabel = self::find($id);
        $kolom = DB::table('kolom')->where('id_tabel', $tabel->id)->get()->toArray();
        $baris = DB::table('baris')->where('id_tabel', $tabel->id)->get()->toArray();
        $cells = DB::table('data')->whereIn('id_baris', array_column($baris, 'id'))->get();

        $data = [];
        foreach ($cells as $cell) {
            $rowId = $cell->id_baris;
            $columnId = $cell->id_kolom;
            $value = $cell->data;

            // Cari nama kolom berdasarkan column_id
            $columnName = array_column($kolom, 'nama', 'id')[$columnId];
            $data[$rowId][$columnName] = $value;
        }

        return [
            'tabel' => $tabel,
            'kolom' => $kolom,
            'baris' => $baris,
            'data' => $data,
        ];
    }
}
