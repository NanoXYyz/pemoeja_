<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan updateOrCreate agar tidak error jika seeder dijalankan ulang
        User::updateOrCreate(
            ['email' => 'admin@mail.com'], // Identifier unik
            [
                'name' => 'Admin',
                'password' => Hash::make('adminbolu123'), 
                'role' => 'admin', // Sesuai dengan pengecekan di LoginController & AdminMiddleware
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('AdminSeeder: Akun admin@mail.com berhasil dibuat!');
    }
}