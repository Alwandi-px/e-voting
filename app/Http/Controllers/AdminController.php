<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Kandidat;
use App\Models\Vote;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. Dashboard Admin (Berisi Statistik Lengkap DPT, Suara Masuk, dll)
    public function dashboard()
    {
        $totalPemilih = User::where('peran', '!=', 'admin')->count();
        $totalSuaraMasuk = Vote::count();
        $totalBelumVote = User::where('peran', '!=', 'admin')->where('status_voted', 'belum')->count();
        $persentaseMasuk = $totalPemilih > 0 ? round(($totalSuaraMasuk / $totalPemilih) * 100, 1) : 0;

        // Rincian Guru vs Siswa
        $guruTotal = User::where('peran', 'guru')->count();
        $guruVoted = User::where('peran', 'guru')->where('status_voted', 'sudah')->count();

        $siswaTotal = User::where('peran', 'siswa')->count();
        $siswaVoted = User::where('peran', 'siswa')->where('status_voted', 'sudah')->count();

        // 5 Aktivitas Waktu Pencoblosan Terbaru (Tanpa relasi user untuk menjaga privasi)
        $recentVotes = Vote::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPemilih',
            'totalSuaraMasuk',
            'totalBelumVote',
            'persentaseMasuk',
            'guruTotal',
            'guruVoted',
            'siswaTotal',
            'siswaVoted',
            'recentVotes'
        ));
    }

    // 2. Layar Display Quick Count Khusus Proyektor / TV
    public function quickCount()
    {
        $totalPemilih = User::where('peran', '!=', 'admin')->count();
        $totalSuaraMasuk = Vote::count();
        $kandidats = Kandidat::withCount('votes')->orderBy('nomor_urut', 'asc')->get();

        return view('admin.quickcount', compact('totalPemilih', 'totalSuaraMasuk', 'kandidats'));
    }

    // 3. Import & Filter Pemilih
    public function index(Request $request)
    {
        $query = User::where('peran', '!=', 'admin');

        // Fitur Searching (Cari Nama, NISN/Nomor Induk, atau Kelas/Jabatan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', '%' . $search . '%')
                    ->orWhere('nomor_induk', 'LIKE', '%' . $search . '%')
                    ->orWhere('kelas_jabatan', 'LIKE', '%' . $search . '%');
            });
        }

        // Filter Peran (Siswa / Guru)
        if ($request->filled('peran')) {
            $query->where('peran', $request->peran);
        }

        // Filter Status Vote (Sudah / Belum)
        if ($request->filled('status')) {
            $query->where('status_voted', $request->status);
        }

        $users = $query->orderBy('id', 'asc')->get();

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

    // 4. Kelola Paslon (FULL CRUD)
    public function kandidatIndex()
    {
        $kandidats = Kandidat::orderBy('nomor_urut', 'asc')->get();
        return view('admin.kandidat', compact('kandidats'));
    }

    public function kandidatStore(Request $request)
    {
        $request->validate([
            'nomor_urut' => 'required|numeric|unique:kandidats,nomor_urut',
            'nama_ketua' => 'required|string',
            'nama_wakil' => 'required|string',
            'foto'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'visi'       => 'required|string',
            'misi'       => 'required|string',
            'proker'     => 'nullable|string',
        ]);

        // 1. Simpan foto ke storage terlebih dahulu agar variabel $fotoPath terdefinisi
        $fotoPath = $request->file('foto')->store('kandidat', 'public');

        // 2. Buat data kandidat baru
        Kandidat::create([
            'nomor_urut' => $request->nomor_urut,
            'nama_ketua' => $request->nama_ketua,
            'nama_wakil' => $request->nama_wakil,
            'foto'       => $fotoPath, // $fotoPath dipanggil setelah dibuat
            'visi'       => $request->visi,
            'misi'       => $request->misi,
            'proker'     => $request->proker,
        ]);

        return redirect()->back()->with('sukses', 'Data Paslon berhasil ditambahkan!');
    }

    public function kandidatUpdate(Request $request, $id)
    {
        $kandidat = Kandidat::findOrFail($id);

        $request->validate([
            'nomor_urut' => 'required|numeric|unique:kandidats,nomor_urut,' . $id,
            'nama_ketua' => 'required|string',
            'nama_wakil' => 'required|string',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'visi'       => 'required|string',
            'misi'       => 'required|string',
        ]);

        $data = [
            'nomor_urut' => $request->nomor_urut,
            'nama_ketua' => $request->nama_ketua,
            'nama_wakil' => $request->nama_wakil,
            'visi'       => $request->visi,
            'misi'       => $request->misi,
            'proker'     => $request->proker,
        ];

        if ($request->hasFile('foto')) {
            if ($kandidat->foto && Storage::disk('public')->exists($kandidat->foto)) {
                Storage::disk('public')->delete($kandidat->foto);
            }
            $data['foto'] = $request->file('foto')->store('kandidat', 'public');
        }

        $kandidat->update($data);

        return redirect()->route('admin.kandidat')->with('sukses', 'Data Paslon berhasil diperbarui!');
    }

    public function kandidatDestroy($id)
    {
        $kandidat = Kandidat::findOrFail($id);

        if ($kandidat->foto && Storage::disk('public')->exists($kandidat->foto)) {
            Storage::disk('public')->delete($kandidat->foto);
        }

        $kandidat->delete();

        return redirect()->route('admin.kandidat')->with('sukses', 'Data Paslon berhasil dihapus!');
    }

    // 5. Reset Semua Data Pemilih
    public function resetPemilih()
    {
        try {
            DB::transaction(function () {
                Vote::query()->delete();
                User::where('peran', '!=', 'admin')->delete();
            });

            return redirect()->back()->with('sukses', 'Data pemilih dan seluruh hasil suara berhasil di-reset total!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Gagal mereset data: ' . $e->getMessage());
        }
    }

    // 6. Reset Suara (Fix 100%)
    public function resetSuara()
    {
        try {
            DB::transaction(function () {
                // Hapus seluruh baris di tabel votes
                Vote::query()->delete();

                // Kembalikan status_voted SEMUA pemilih menjadi 'belum'
                User::where('peran', '!=', 'admin')->update([
                    'status_voted' => 'belum'
                ]);
            });

            return redirect()->route('admin.dashboard')->with('sukses', 'Seluruh data suara berhasil di-reset menjadi 0!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Gagal mereset suara: ' . $e->getMessage());
        }
    }
}
