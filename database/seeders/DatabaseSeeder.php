<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
    
        $user = User::inRandomOrder()->get()->first();
        $tabel = 'user_'.$user->id.'_nilai_siswa';

        DB::table('user_tabel')->insert([
            'id_user' => $user->id,
            'nama' => 'nilai_siswa',
            'nama_asli' => $tabel,
        ]);
        DB::statement("create table {$tabel} (id int primary key auto_increment, nama varchar(200), mapel varchar(100), nilai int)");
        
        $data = [];
        $siswa = [];
        $mapel = ['Matematika', 'Bahasa Jawa', 'IPA', 'IPS', 'Bahasa Indonesia', 'PJOK', 'Sejarah', 'Bahasa Inggris'];
        for($i = 1; $i <= 30; $i++){
            array_push($siswa, fake()->name());
        }

        foreach ($mapel as $mata) {
            foreach($siswa as $s){
                array_push($data, [
                    'nama' => $s,
                    'mapel' => $mata,
                    'nilai' => fake()->numberBetween(34, 99),
                ]);
            }
        }

        DB::table($tabel)->insert($data);

        // ambil rata rata
        $data = [
            [
                "id_user" => $user->id,
                "judul" => "Nilai rata rata siswa",
                "tipe" => "bar",
                "orientasi" => "v",
                "query" => "select nama as siswa, avg(nilai) as rata2 from nilai_siswa group by siswa",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
                "mr" => "2",
                "ml" => "20",
                "mt" => "8",
                "mb" => "7",
                "max_sumbu" => null,
                "pie_kolom" => null
            ],
            [
                "id_user" => $user->id,
                "judul" => "Nilai rata rata mapel",
                "tipe" => "bar",
                "orientasi" => "h",
                "query" => "select mapel, avg(nilai) as rata2 from nilai_siswa group by mapel",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
                "mr" => "2",
                "ml" => "4",
                "mt" => "10",
                "mb" => "7",
                "max_sumbu" => null,
                "pie_kolom" => null
            ],
        ];

        // ambil nilai mapel dari 1 siswa
        for($i = 1; $i <= 5; $i++){
            $nama = Arr::random($siswa);
            array_push($data, [
                "id_user" => $user->id,
                "judul" => "Nilai ".$nama,
                "tipe" => "pie",
                "orientasi" => "h",
                "query" => "select mapel, nilai from nilai_siswa where nama = '{$nama}'",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
                "mr" => "2",
                "ml" => "10",
                "mt" => "20",
                "mb" => "7",
                "max_sumbu" => null,
                "pie_kolom" => null
            ]);
        }

        // ambil nilai siswa dari 1 mapel
        for($i = 1; $i <= 6; $i++){
            $pelajaran = Arr::random($mapel);
            array_push($data, [
                "id_user" => $user->id,
                "judul" => "Nilai ".$pelajaran,
                "tipe" => "bar",
                "orientasi" => "h",
                "query" => "select nama, nilai from nilai_siswa where mapel = '{$pelajaran}'",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
                "mr" => "2",
                "ml" => "20",
                "mt" => "8",
                "mb" => "7",
                "max_sumbu" => null,
                "pie_kolom" => null
            ]);
        }

        // grafik radar
        for($i = 1; $i <= 6; $i++){
            $pelajaran = Arr::random($mapel, 5);
            $nama = Arr::random($siswa, 5);

            $select_column = [];
            foreach($pelajaran as $mata){
                array_push($select_column, "MAX(CASE WHEN mapel = '{$mata}' THEN nilai END) AS '{$mata}'");
            }
            $select_query = implode(", ", $select_column);
            $in_siswa = [];
            foreach($nama as $s){
                array_push($in_siswa, "'{$s}'");
            }
            $in_query = implode(", ", $in_siswa);

            array_push($data, [
                "id_user" => $user->id,
                "judul" => "Tes Kemampuan Siswa Batch ".$i,
                "tipe" => "radar",
                "orientasi" => "h",
                "query" => "select nama as siswa, {$select_query} from nilai_siswa where nama in ({$in_query}) group by nama",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
                "mr" => "2",
                "ml" => "10",
                "mt" => "20",
                "mb" => "7",
                "max_sumbu" => 100,
                "pie_kolom" => null
            ]);
        }

        DB::table('user_grafik')->insert($data);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
