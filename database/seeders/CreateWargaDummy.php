<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateWargaDummy extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        foreach (range(1, 100) as $index) {
            DB::table('warga')->insert([
                'no_ktp'        => $faker->unique()->numerify('1404##########'),
                'nama'          => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama'         => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'pekerjaan'     => $faker->randomElement(['Petani', 'Guru', 'PNS', 'Pedagang', 'Mahasiswa', 'Karyawan Swasta']),
                'telp'          => $faker->phoneNumber,
                'email'         => $faker->unique()->safeEmail,
            ]);
        }
    }
}
