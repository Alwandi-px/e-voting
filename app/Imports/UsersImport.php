<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $nomorInduk = $row['nomor_induk'] ?? $row['nisn'] ?? null;

        if (empty($nomorInduk)) {
            return null;
        }

        $rawPeran = strtolower(trim($row['peran'] ?? ''));
        $kelasJabatan = strtolower(trim($row['kelas_jabatan'] ?? ''));

        // Cek Siswa: mendukung angka 10, 11, 12 DAN romawi x, xi, xii, serta kata 'siswa'/'murid'
        $isSiswa = str_contains($rawPeran, 'siswa') ||
            str_contains($rawPeran, 'murid') ||
            preg_match('/\b(10|11|12|x|xi|xii)\b/i', $kelasJabatan) ||
            preg_match('/\b(10|11|12|x|xi|xii)\b/i', $rawPeran);

        $peran = $isSiswa ? 'siswa' : 'guru';

        return User::updateOrCreate(
            ['nomor_induk' => trim($nomorInduk)],
            [
                'nama'          => trim($row['nama']),
                'peran'         => $peran,
                'kelas_jabatan' => trim($row['kelas_jabatan'] ?? '-'),
                'status_voted'  => 'belum',
            ]
        );
    }
}
