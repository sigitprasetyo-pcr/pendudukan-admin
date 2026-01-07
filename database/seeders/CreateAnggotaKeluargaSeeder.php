<?php

namespace Database\Seeders;

use App\Models\AnggotaKeluarga;
use App\Models\KeluargaKK;
use App\Models\Warga;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CreateAnggotaKeluargaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $keluargaKK = KeluargaKK::all();
        $warga = Warga::all();

        if ($keluargaKK->isEmpty() || $warga->isEmpty()) {
            $this->command->error('Seeder gagal: data KK atau Warga masih kosong.');
            return;
        }

        // Bersihkan dulu biar tidak bentrok
        AnggotaKeluarga::truncate();

        $hubunganList = [
            'Istri',
            'Anak',
            'Ayah',
            'Ibu',
            'Menantu',
            'Cucu',
            'Saudara',
        ];

        // Supaya warga tidak dobel di banyak KK
        $wargaPool = $warga->shuffle();

        foreach ($keluargaKK as $kk) {

            // 🔹 1. Kepala Keluarga (WAJIB 1)
            if ($kk->kepalaKeluarga) {
                AnggotaKeluarga::create([
                    'kk_id'    => $kk->kk_id,
                    'warga_id'=> $kk->kepalaKeluarga->warga_id,
                    'hubungan'=> 'Kepala Keluarga',
                ]);
            }

            // 🔹 2. Anggota lain (2–6 orang)
            $jumlahAnggota = rand(2, 6);

            for ($i = 0; $i < $jumlahAnggota; $i++) {

                if ($wargaPool->isEmpty()) {
                    break;
                }

                $w = $wargaPool->shift();

                // Skip kalau kepala keluarga
                if ($kk->kepalaKeluarga && $w->warga_id == $kk->kepalaKeluarga->warga_id) {
                    continue;
                }

                AnggotaKeluarga::create([
                    'kk_id'    => $kk->kk_id,
                    'warga_id'=> $w->warga_id,
                    'hubungan'=> $faker->randomElement($hubunganList),
                ]);
            }
        }

        $this->command->info('✔ Seeder Anggota Keluarga berhasil dibuat secara valid & realistis.');
    }
}
