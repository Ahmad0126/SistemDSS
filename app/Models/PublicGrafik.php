<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PublicGrafik extends Model
{
    use HasFactory;
    protected $table = 'public_grafik';

    public static function getAll(){
        return DB::table(DB::raw('public_grafik p'))
            ->selectRaw('p.id, p.image, g.judul, u.nama')
            ->join(DB::raw('user_grafik g'), 'g.id', '=', 'p.id_grafik')
            ->join(DB::raw('users u'), 'u.id', '=', 'g.id_user')
            ->get();
    }
    public static function getMine($limit = null){
        $grafik = DB::table(DB::raw('public_grafik p'))
            ->selectRaw('p.id, p.image, g.judul')
            ->join(DB::raw('user_grafik g'), 'g.id', '=', 'p.id_grafik')
            ->where('g.id_user', auth()->id());

        if($limit){
            return $grafik->limit($limit)->get();
        }else{
            return $grafik->get();
        }
    }
}
