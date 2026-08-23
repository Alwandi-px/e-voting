<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Ambil nilai nomor_induk / nisn
        $nomorInduk = $row['nomor_induk'] ?? $row['nisn'] ?? null;

        if (empty($nomorInduk)) {
            return null;
        }

        $peran = strtolower(trim($row['peran'] ?? 'siswa'));
        if ($peran !== 'guru') {
            $peran = 'siswa';
        }

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
