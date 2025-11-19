<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\AnggotaKeluarga;
use App\Models\KeluargaKK;
use App\Models\Warga;

class CreateAnggotaKeluargaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $kk_ids = KeluargaKK::pluck('kk_id')->toArray();
        $warga_ids = Warga::pluck('warga_id')->toArray();

        if (count($kk_ids) === 0 || count($warga_ids) === 0) {
            $this->command->warn('⚠ Data tidak cukup! Seeder dihentikan.');
            return;
        }

        foreach ($kk_ids as $kk_id) {
            foreach (range(1, rand(2, 5)) as $i) {
                AnggotaKeluarga::create([
                    'kk_id' => $kk_id,
                    'warga_id' => $faker->randomElement($warga_ids),
                    'hubungan' => $faker->randomElement(['Ayah','Ibu','Anak','Saudara']),
                ]);
            }
        }

        $this->command->info('✔ Anggota keluarga berhasil dibuat!');
    }
}
