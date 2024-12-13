<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserGrafik extends Model
{
    use HasFactory;
    protected $table = 'user_grafik';

    public static function getMine(){
        return DB::table(DB::raw('user_grafik g'))
            ->selectRaw('g.id, judul, tipe, p.id_grafik')
            ->join(DB::raw('public_grafik p'), 'g.id', '=', 'p.id_grafik', 'left')
            ->where('id_user', auth()->id())
            ->get();
    }
}
