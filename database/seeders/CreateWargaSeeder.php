<?php

namespace Database\Seeders;

use App\Models\Warga;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CreateWargaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        foreach (range(1, 100) as $i) {
            Warga::create([
                'no_ktp'        => $faker->unique()->numerify('32##############'),
                'nama'          => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['Laki-Laki', 'Perempuan']),
                'agama'         => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha']),
                'pekerjaan'     => $faker->jobTitle,
                'telp'          => $faker->numerify('08##########'),
                'email'         => $faker->optional()->safeEmail,
            ]);
        }

        $this->command->info('✔ 100 Data Warga berhasil dibuat.');
    }
}
