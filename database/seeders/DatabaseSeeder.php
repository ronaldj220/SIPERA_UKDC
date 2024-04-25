<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin\Role;
use App\Models\Role_Has_User;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'role' => 'Admin'
        ]);
        Role::create([
            'role' => 'Pelamar'
        ]);
        Role::create([
            'role' => 'Karyawan'
        ]);
        Role::create([
            'role' => 'Dosen'
        ]);

        // Pembuatan Tabel User khusus Admin
        User::create([
            'nama' => 'Kepala BAU',
            'email' => 'bau@ukdc.ac.id',
            'password' => Hash::make('12345'),
            'gender' => 'W',
            'is_active' => 0
        ]);

        // Pembuatan Tabel Hubungan antara Role dengan User
        Role_Has_User::create([
            'fk_role' => 1,
            'fk_user' => 1
        ]);
    }
}
