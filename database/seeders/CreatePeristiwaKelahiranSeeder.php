<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\PeristiwaKelahiran;
use App\Models\Warga;
use Illuminate\Support\Facades\DB;

class CreatePeristiwaKelahiranSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Kosongkan tabel peristiwa kelahiran
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PeristiwaKelahiran::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil seluruh warga
        $warga = Warga::get();

        if ($warga->count() < 2) {
            $this->command->error('❌ Data warga tidak cukup untuk membuat peristiwa kelahiran.');
            return;
        }

        foreach (range(1, 10) as $i) {

            $ayah = Warga::where('jenis_kelamin', 'Laki-Laki')->inRandomOrder()->first();
            $ibu  = Warga::where('jenis_kelamin', 'Perempuan')->inRandomOrder()->first();

            if (!$ayah || !$ibu) {
                $this->command->warn('⚠ Ayah atau Ibu tidak ditemukan. Melewati 1 data.');
                continue;
            }

            // Buat bayi baru
            $bayi = Warga::create([
                'no_ktp'        => $faker->unique()->numerify('3273############'),
                'nama'          => $faker->firstName . ' ' . $ayah->nama,
                'jenis_kelamin' => $faker->randomElement(['Laki-Laki', 'Perempuan']),
                'agama'         => $ayah->agama,
                'pekerjaan'     => null,
                'telp'          => null,
                'email'         => null,
            ]);

            // Masukkan data kelahiran
            PeristiwaKelahiran::create([
                'warga_id'      => $bayi->warga_id,
                'tgl_lahir'     => $faker->date(),
                'tempat_lahir'  => $faker->city,
                'ayah_warga_id' => $ayah->warga_id,
                'ibu_warga_id'  => $ibu->warga_id,
                'no_akta'       => $faker->unique()->numerify('AKTA-#####'),
            ]);
        }

        $this->command->info('✔️ 10 Data Peristiwa Kelahiran berhasil dibuat.');
    }
}
