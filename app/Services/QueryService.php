<?php

namespace App\Services;

use App\Models\UserTabel;

class QueryService{
    public function modifyQuery(string $query, int $userId): string{
        $tabel = UserTabel::where('id_user', $userId)->get();

        foreach($tabel as $t){
            $qu = str_replace(" {$t->nama}", " {$t->nama_asli}", $query);
            if($qu != $query){ break; }
        }
        return $qu;
    }
}