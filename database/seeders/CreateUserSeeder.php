<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Hapus baris "use Database\Seeders\CreateFirstUser;" yang salah

class CreateUserSeeder extends Seeder // Ubah nama class menjadi UserSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan tidak ada pengecekan Foreign Key yang mengganggu
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data yang ada dan reset auto-increment
        DB::table('users')->truncate();

        $users = [
            [
                'name' => 'Admin Sistem',
                'email' => 'admin@pcr.ac.id',
                'password' => Hash::make('admin123'),
            ],
            [
                'name' => 'Operator Data',
                'email' => 'operator@pcr.ac.id',
                'password' => Hash::make('operator123'),
            ],
            [
                'name' => 'User Biasa',
                'email' => 'user@pcr.ac.id',
                'password' => Hash::make('user123'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('✅ Tiga akun user default (Admin, Operator, User) berhasil dibuat.');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
