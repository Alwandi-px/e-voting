<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kandidat;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    // Tampilkan Halaman Bilik Suara (Kandidat)
    public function index()
    {
        // Ambil pemilih dari Auth atau Session
        $user = Auth::user() ?? User::find(session('user_id'));

        if (!$user) {
            return redirect()->route('login')->with('gagal', 'Silakan login terlebih dahulu!');
        }

        if ($user->status_voted === 'sudah') {
            Auth::logout();
            session()->forget('user_id');
            return redirect()->route('login')->with('gagal', 'Anda sudah menggunakan hak pilih sebelumnya!');
        }

        $kandidats = Kandidat::orderBy('nomor_urut', 'asc')->get();
        return view('voting.index', compact('user', 'kandidats'));
    }

    // Proses Coblos Paslon (Atomic / Safe dari Double Click & Lag)
    public function store(Request $request)
    {
        $request->validate([
            'kandidat_id' => 'required|exists:kandidats,id'
        ]);

        $user = Auth::user() ?? User::find(session('user_id'));

        if (!$user) {
            return redirect()->route('login')->with('gagal', 'Sesi login telah berakhir, silakan login ulang.');
        }

        // 1. Cek Ulang Status Voted (Double Protection)
        if ($user->status_voted === 'sudah') {
            return redirect()->route('login')->with('gagal', 'Anda sudah menggunakan hak pilih sebelumnya!');
        }

        try {
            // Menggunakan DB Transaction & Lock Record (Mencegah Race Condition / Double Submit)
            DB::transaction(function () use ($user, $request) {
                // Lock record user agar request beruntun dari tombol tidak terproses ganda
                $currentUser = User::where('id', $user->id)->lockForUpdate()->first();

                if ($currentUser->status_voted === 'sudah') {
                    throw new \Exception('Sudah memilih.');
                }

                // 1. Simpan suara ke tabel vote (TIDAK menyimpang user_id agar asas LUBER JURDIL terjaga)
                Vote::create([
                    'kandidat_id' => $request->kandidat_id,
                ]);

                // 2. Tandai status user menjadi 'sudah'
                $currentUser->update([
                    'status_voted' => 'sudah'
                ]);
            });

            // Logout & Bersihkan Session setelah berhasil nyoblos
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('sukses_vote', 'Suara Anda telah BERHASIL disimpan! Terima kasih atas partisipasi Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Gagal menyimpan suara! Silakan coba beberapa saat lagi.');
        }
    }
}
