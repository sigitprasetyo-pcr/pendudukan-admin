<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\KeluargaKK;
use App\Models\Warga;

class CreateKeluargaKKSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $warga = Warga::pluck('warga_id')->toArray();

        if (count($warga) === 0) {
            $this->command->warn('⚠️ Tabel warga kosong! Seeder KeluargaKK dihentikan.');
            return;
        }

        foreach (range(1, 100) as $i) {
            KeluargaKK::create([
                'kk_nomor' => $faker->unique()->numerify('3172##########'),
                'kepala_keluarga_warga_id' => $faker->randomElement($warga),
                'alamat' => $faker->address,
                'rt'     => str_pad($faker->numberBetween(1, 20), 2, '0', STR_PAD_LEFT),
                'rw'     => str_pad($faker->numberBetween(1, 20), 2, '0', STR_PAD_LEFT),
            ]);
        }

        $this->command->info('✔ 100 Data KeluargaKK berhasil dibuat.');
    }
}
