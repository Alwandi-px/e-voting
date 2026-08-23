<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    // 1. Tampilkan Halaman Landing / Pilihan Peran (Siswa vs Guru)
    public function showRoleSelection()
    {
        return view('auth.role');
    }

    // 2. Tampilkan Form Login Sesuai Peran yang Pilih
    public function showLoginRole($role)
    {
        if (!in_array($role, ['siswa', 'guru'])) {
            return redirect()->route('login');
        }

        return view('auth.login', compact('role'));
    }

    // 3. Proses Login Nomor Induk (NISN / NIP)
    // 3. Proses Login Nomor Induk (NISN / NIP)
    public function processLogin(Request $request)
    {
        $request->validate([
            'nomor_induk' => 'required',
            'peran'       => 'required'
        ], [
            'nomor_induk.required' => 'Nomor Induk wajib diisi!'
        ]);

        // Menggunakan LOWER() agar pencarian peran tidak sensitif huruf besar/kecil (SISWA vs siswa)
        $user = User::where('nomor_induk', trim($request->nomor_induk))
            ->whereRaw('LOWER(peran) = ?', [strtolower($request->peran)])
            ->first();

        // Cek jika akun tidak ditemukan atau salah pilih peran
        if (!$user) {
            $label = $request->peran == 'guru' ? 'Kode / NIP Guru' : 'NISN Siswa';
            return redirect()->back()->with('gagal', "$label tidak ditemukan atau salah pilih kategori!");
        }

        // Cek jika sudah pernah memilih
        if ($user->status_voted === 'sudah') {
            return redirect()->back()->with('gagal', 'Anda SUDAH menggunakan hak pilih! Tidak dapat memilih kembali.');
        }

        // Simpan Session
        session(['user_id' => $user->id]);

        return redirect()->route('voting.index');
    }

    // Logout
    public function logout()
    {
        session()->forget('user_id');
        return redirect()->route('login')->with('sukses', 'Terima kasih telah menggunakan hak pilih Anda!');
    }
}
