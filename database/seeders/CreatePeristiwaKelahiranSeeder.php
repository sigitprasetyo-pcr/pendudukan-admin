<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\PeristiwaKelahiran;
use App\Models\Warga;

class CreatePeristiwaKelahiranSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $ayahList = Warga::where('jenis_kelamin', 'Laki-Laki')->pluck('warga_id')->toArray();
        $ibuList  = Warga::where('jenis_kelamin', 'Perempuan')->pluck('warga_id')->toArray();

        if (empty($ayahList) || empty($ibuList)) {
            $this->command->warn('⚠ Tidak ditemukan data ayah/ibu! Seeder dihentikan.');
            return;
        }

        foreach (range(1, 100) as $i) {

            $ayah_id = $faker->randomElement($ayahList);
            $ibu_id  = $faker->randomElement($ibuList);

            // Buat bayi (otomatis masuk ke tabel warga)
            $bayi = Warga::create([
                'no_ktp'        => $faker->unique()->numerify('3301############'),
                'nama'          => $faker->firstName . ' ' . Warga::find($ayah_id)->nama,
                'jenis_kelamin' => $faker->randomElement(['Laki-Laki', 'Perempuan']),
                'agama'         => Warga::find($ayah_id)->agama,
                'pekerjaan'     => null,
                'telp'          => null,
                'email'         => null,
            ]);

            PeristiwaKelahiran::create([
                'warga_id'      => $bayi->warga_id,
                'tgl_lahir'     => $faker->date(),
                'tempat_lahir'  => $faker->city,
                'ayah_warga_id' => $ayah_id,
                'ibu_warga_id'  => $ibu_id,
                'no_akta'       => $faker->unique()->numerify('AKTA-########'),
            ]);
        }

        $this->command->info('✔ 100 Data Peristiwa Kelahiran berhasil dibuat.');
    }
}
