<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateKeluargaKkDummy extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        // Ambil semua warga_id untuk digunakan sebagai FK kepala keluarga
        $wargaIDs = DB::table('warga')->pluck('warga_id')->toArray();

        foreach (range(1, 30) as $index) {
            DB::table('keluarga_kk')->insert([
                'kk_nomor'                 => $faker->unique()->numerify('3273##########'),
                'kepala_keluarga_warga_id' => $faker->randomElement($wargaIDs),
                'alamat'                   => $faker->address,
                'rt'                       => $faker->numberBetween(1, 10),
                'rw'                       => $faker->numberBetween(1, 5),
            ]);
        }
    }
}
