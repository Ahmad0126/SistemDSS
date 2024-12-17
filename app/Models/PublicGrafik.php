<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicGrafik extends Model
{
    use HasFactory;
    protected $table = 'public_grafik';

    public static function getAll(){
        return DB::table(DB::raw('public_grafik p'))
            ->selectRaw('p.id, g.judul, u.nama')
            ->join(DB::raw('user_grafik g'), 'g.id', '=', 'p.id_grafik')
            ->join(DB::raw('users u'), 'u.id', '=', 'g.id_user')
            ->orderByRaw('p.created_at desc')
            ->paginate(8);
    }
    public static function getMine($limit = null){
        $grafik = DB::table(DB::raw('public_grafik p'))
            ->selectRaw('p.id, g.judul')
            ->join(DB::raw('user_grafik g'), 'g.id', '=', 'p.id_grafik')
            ->where('g.id_user', auth()->id())
            ->orderByRaw('p.created_at desc');

        if($limit){
            return $grafik->limit($limit)->get();
        }else{
            return $grafik->get();
        }
    }
    public static function getSingle($id = null){
        if(!$id) abort(404);

        return DB::table(DB::raw('public_grafik p'))
            ->select(['p.id', 'p.id_grafik', 'g.judul', 'g.id_user', 'u.nama', 'p.created_at',
                'g.ml', 'g.mr', 'g.mb', 'g.mt', 'g.tipe', 'g.orientasi', 'g.query'])
            ->join(DB::raw('user_grafik g'), 'g.id', '=', 'p.id_grafik')
            ->join(DB::raw('users u'), 'u.id', '=', 'g.id_user')
            ->where('p.id', $id)
            ->get();
    }
    public static function search(Request $req){
        $data = DB::table(DB::raw('public_grafik p'))
            ->selectRaw('p.id, g.judul, u.nama')
            ->join(DB::raw('user_grafik g'), 'g.id', '=', 'p.id_grafik')
            ->join(DB::raw('users u'), 'u.id', '=', 'g.id_user');

        if($req->key){
            $data->where('judul', 'like', "%{$req->key}%");
        }
        if($req->publisher){
            $data->where('nama', 'like', "%{$req->publisher}%");
        }
        if($req->tipe_grafik){
            $data->where('g.tipe', '=', $req->tipe_grafik);
        }
        if($req->order_by || $req->urutan){
            switch ($req->order_by) {
                case 'judul':
                    $by = 'g.judul ';
                    break;
                case 'nama':
                    $by = 'u.nama ';
                    break;
                
                default:
                    $by = 'p.created_at ';
                    break;
            }

            $data->orderByRaw($by. $req->urutan ?? 'asc');
        }
        
        return $data->paginate(8);
    }
    public static function searchMine($keyword){
        return DB::table(DB::raw('public_grafik p'))
            ->selectRaw('p.id, g.judul, u.nama')
            ->join(DB::raw('user_grafik g'), 'g.id', '=', 'p.id_grafik')
            ->join(DB::raw('users u'), 'u.id', '=', 'g.id_user')
            ->where('judul', 'like', "%{$keyword}%")
            ->where('g.id_user', auth()->id())
            ->orderByRaw('p.created_at desc')
            ->paginate(8);
    }
}
