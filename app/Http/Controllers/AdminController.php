<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Kandidat;
use App\Models\Vote;

class AdminController extends Controller
{
    // 1. Dashboard Admin (Berisi Statistik Lengkap DPT, Suara Masuk, dll)
    public function dashboard()
    {
        $totalPemilih = User::count();
        $totalSuaraMasuk = Vote::count();
        $totalBelumVote = User::where('status_voted', 'belum')->count();
        $persentaseMasuk = $totalPemilih > 0 ? round(($totalSuaraMasuk / $totalPemilih) * 100, 1) : 0;

        return view('admin.dashboard', compact('totalPemilih', 'totalSuaraMasuk', 'totalBelumVote', 'persentaseMasuk'));
    }

    // 2. Layar Display Quick Count (KHUSUS Grafik & Rate Paslon - Tanpa Kartu DPT)
    // Layar Display Quick Count Khusus Proyektor
    public function quickCount()
    {
        $totalPemilih = User::count();
        $totalSuaraMasuk = Vote::count();
        $kandidats = Kandidat::withCount('votes')->orderBy('nomor_urut', 'asc')->get();

        return view('admin.quickcount', compact('totalPemilih', 'totalSuaraMasuk', 'kandidats'));
    }

    // Import Pemilih
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.import', compact('users'));
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:csv,xls,xlsx']);
        try {
            Excel::import(new UsersImport, $request->file('file'));
            return redirect()->back()->with('sukses', 'Data pemilih berhasil di-import!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Kelola Paslon
    public function kandidatIndex()
    {
        $kandidats = Kandidat::orderBy('nomor_urut', 'asc')->get();
        return view('admin.kandidat', compact('kandidats'));
    }

    public function kandidatStore(Request $request)
    {
        $request->validate([
            'nomor_urut' => 'required|numeric|unique:kandidats,nomor_urut',
            'nama_ketua' => 'required',
            'nama_wakil' => 'required',
            'foto'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'visi'       => 'required',
            'misi'       => 'required',
        ]);

        $fotoPath = $request->file('foto')->store('paslon', 'public');

        Kandidat::create([
            'nomor_urut' => $request->nomor_urut,
            'nama_ketua' => $request->nama_ketua,
            'nama_wakil' => $request->nama_wakil,
            'foto'       => $fotoPath,
            'visi'       => $request->visi,
            'misi'       => $request->misi,
        ]);

        return redirect()->back()->with('sukses', 'Data Paslon berhasil ditambahkan!');
    }
}
