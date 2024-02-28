<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'username' => 'admin1',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('password'),
            'nama_lengkap' => 'admin_satu',
            'alamat' => 'Jawa Barat, Subang, Dawuan',
            'role' => 'administrator',
        ]);

        User::create([
            'username' => 'petugas1',
            'email' => 'petugas1@gmail.com',
            'password' => Hash::make('password'),
            'nama_lengkap' => 'petugas_satu',
            'alamat' => 'Jawa Barat, Subang, Dawuan',
            'role' => 'petugas',
        ]);
    }
}
