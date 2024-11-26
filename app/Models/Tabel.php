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
        $kolom = DB::table('kolom')->where('id_tabel', $tabel->id)->orderBy('urutan')->get()->toArray();
        $baris = DB::table('baris')->where('id_tabel', $tabel->id)->orderBy('urutan')->get()->toArray();
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
    public function get_grafik($id){
        $table = $this->getData($id);

        $baris = $table['baris'];
        $kolom = $table['kolom'];
        $t_data = $table['data'];

        $first_kolom = array_slice($kolom, 0, 1);
        $rest_kolom = array_slice($kolom, 1);
        $g_data = [];
        $indicator = [];

        //make g_data
        foreach($baris as $r){
            array_push($g_data, $t_data[$r->id][$first_kolom[0]->nama] ?? []);
        }

        //make indicator
        foreach($rest_kolom as $k){
            array_push($indicator, [
                'name' => $k->nama,
                'max' => $table['tabel']->max_sumbu
            ]);
        }

        switch ($table['tabel']->tipe) {
            case 'radar':
                $series = $this->grafik_radar($t_data, $rest_kolom, $baris, $first_kolom[0]->nama ?? '');
                break;
            case 'pie':
                $series = $this->grafik_pie($t_data, $table['tabel']->pie_kolom, $baris, $first_kolom[0]->nama ?? '', $id);
                break;
            default:
                $series = $this->grafik_biasa($t_data, $rest_kolom, $baris, $table['tabel']->tipe);
                break;
        }

        return [
            'table' => $table,
            'indicator' => $indicator,
            'data' => $g_data,
            'series' => $series,
        ];
    }
    private function grafik_biasa($map, $kolom, $baris, $tipe){
        $series = [];
        foreach($kolom as $k){
            $s_data = [];
            foreach($baris as $r){
                array_push($s_data, $map[$r->id][$k->nama] ?? '');
            }
            array_push($series, [
                'name' => $k->nama,
                'type' => $tipe,
                'data' => $s_data
            ]);
        }

        return $series;
    }
    private function grafik_pie($map, $id_kolom, $baris, $first_kolom, $id_tabel){
        if($id_kolom){
            $kolom = Kolom::find($id_kolom);
        }else{
            $kolom = Kolom::where('id_tabel', $id_tabel)->orderBy('urutan')->limit(2)->get()->last();
        }
        
        $series = [];
        $s_data = [];
        foreach($baris as $r){
            array_push($s_data, [
                'value' => $map[$r->id][$kolom->nama] ?? '',
                'name' => $map[$r->id][$first_kolom] ?? '',
            ]);
        }
        array_push($series, [
            'name' => $kolom->nama,
            'type' => 'pie',
            'data' => $s_data
        ]);
        
        return $series;
    }
    private function grafik_radar($map, $rest_kolom, $baris, $first_kolom){
        $series = [];
        $s_data = [];
        //make series
        foreach($baris as $r){
            $value = [];
            foreach($rest_kolom as $k){
                array_push($value, $map[$r->id][$k->nama] ?? '');
            }
            array_push($s_data, [
                'name' => $map[$r->id][$first_kolom] ?? '',
                'value' => $value
            ]);
        }
        array_push($series, [
            'type' => 'radar',
            'data' => $s_data
        ]);
        return $series;
    }
}
