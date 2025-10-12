<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $users = [
            [
                'name' => 'Owner Utama',
                'email' => 'owner@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'Owner',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'Karyawan',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'Karyawan',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'Karyawan',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'Karyawan',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi@example.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'role' => 'Karyawan',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);

        // Atau menggunakan Model User
        // use App\Models\User;
        // foreach ($users as $userData) {
        //     User::create($userData);
        // }

        $this->command->info('User seeder berhasil dijalankan! Total: ' . count($users) . ' users');
    }
}
