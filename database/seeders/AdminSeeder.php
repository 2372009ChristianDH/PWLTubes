<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Buat user admin
        $user = User::create([
            'nama' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'id_roles' => 1,
        ]);

        // Buat data karyawannya
        Karyawan::create([
            'nik' => '1000001',
            'id_program_studi' => 1,
            'id_users' => $user->id,
            'tahun_mulai' => Carbon::now()->toDateString(),
            'status_karyawan' => 'Aktif',
        ]);
    }
}

