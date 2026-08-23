<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Administrator Pemilos',
            'nomor_induk' => 'admin',
            'peran' => 'admin',
            'kelas_jabatan' => 'PANITIA',
            'status_memilih' => false,
        ]);

        User::create([
            'nama' => 'Guru Pembimbing',
            'nomor_induk' => 'G001',
            'peran' => 'guru',
            'kelas_jabatan' => 'GURU RPL',
            'status_memilih' => false,
        ]);

        User::create([
            'nama' => 'Siswa Pemilih',
            'nomor_induk' => '0061234561',
            'peran' => 'siswa',
            'kelas_jabatan' => 'XII RPL 1',
            'status_memilih' => false,
        ]);
    }
}
