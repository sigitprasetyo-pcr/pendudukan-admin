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

        // Ambil semua warga_id
        $warga = Warga::pluck('warga_id')->toArray();

        // Jika data warga kosong, beri peringatan
        if (count($warga) === 0) {
            $this->command->warn('⚠️ Seeder KeluargaKK DIHENTIKAN: Tabel warga kosong!');
            return;
        }

        // Generate 20 data keluarga
        foreach (range(1, 20) as $i) {

            KeluargaKK::create([
                'kk_nomor' => $faker->unique()->numerify('3273##########'),
                'kepala_keluarga_warga_id' => $faker->randomElement($warga), // WAJIB VALID
                'alamat' => $faker->address,
                'rt'     => str_pad($faker->numberBetween(1, 20), 2, '0', STR_PAD_LEFT),
                'rw'     => str_pad($faker->numberBetween(1, 20), 2, '0', STR_PAD_LEFT),
            ]);
        }

        $this->command->info('✔️ Seeder CreateKeluargaKKSeeder berhasil dijalankan!');
    }
}
