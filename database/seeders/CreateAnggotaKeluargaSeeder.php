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

        if (empty($kk_ids) || empty($warga_ids)) {
            $this->command->warn('⚠ Data tidak cukup! Seeder AnggotaKeluarga dihentikan.');
            return;
        }

        foreach (range(1, 100) as $i) {
            AnggotaKeluarga::create([
                'kk_id'       => $faker->randomElement($kk_ids),
                'warga_id'    => $faker->randomElement($warga_ids),
                'hubungan'    => $faker->randomElement(['Ayah','Ibu','Anak','Saudara']),
            ]);
        }

        $this->command->info('✔ 100 Data Anggota Keluarga berhasil dibuat.');
    }
}
