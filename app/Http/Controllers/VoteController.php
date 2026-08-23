<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kandidat;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    // Tampilkan Halaman Bilik Suara (Kandidat)
    public function index()
    {
        if (!session('user_id')) {
            return redirect()->route('login')->with('gagal', 'Silakan login terlebih dahulu!');
        }

        $user = User::find(session('user_id'));

        if (!$user || $user->status_voted === 'sudah') {
            session()->forget('user_id');
            return redirect()->route('login')->with('gagal', 'Anda sudah memilih atau akun tidak valid!');
        }

        $kandidats = Kandidat::orderBy('nomor_urut', 'asc')->get();
        return view('voting.index', compact('user', 'kandidats'));
    }

    // Proses Coblos Paslon (Atomic / Safe)
    public function store(Request $request)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'kandidat_id' => 'required|exists:kandidats,id'
        ]);

        $userId = session('user_id');

        // Gunakan DB Transaction agar proses simpan vote & ganti status bersifat ATOMIC (aman dari lag/double click)
        DB::transaction(function () use ($userId, $request) {
            $user = User::where('id', $userId)->lockForUpdate()->first();

            if ($user && $user->status_voted === 'belum') {
                // 1. Catat Suara
                Vote::create([
                    'kandidat_id' => $request->kandidat_id
                ]);

                // 2. Ubah Status Pemilih jadi 'sudah'
                $user->update([
                    'status_voted' => 'sudah'
                ]);
            }
        });

        // Hapus session dan arahkan ke logout
        session()->forget('user_id');

        return redirect()->route('login')->with('sukses', 'Suara Anda BERHASIL disimpan. Terima kasih telah berpartisipasi!');
    }
}
