<?php

namespace App\Services;

use App\Models\Tabel;

class QueryService{
    public function modifyQuery(string $query, int $userId): string{
        $tabel = Tabel::where('id_user', $userId)->get();

        foreach($tabel as $t){
            $qu = str_replace(" {$t->nama}", " {$t->nama_asli}", $query);
            if($qu != $query){ break; }
        }
        return $qu;
    }
}