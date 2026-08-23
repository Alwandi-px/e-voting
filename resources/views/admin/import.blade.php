<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Data Pemilih - Pemilos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-4">
        <!-- Tombol Kembali ke Dashboard -->
        <div class="mb-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary fw-bold rounded-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard Admin
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white font-weight-bold">
                                Import Data Pemilih (Siswa / Guru)
                            </div>
                            <div class="card-body">

                                @if(session('sukses'))
                                <div class="alert alert-success">{{ session('sukses') }}</div>
                                @endif

                                @if(session('gagal'))
                                <div class="alert alert-danger">{{ session('gagal') }}</div>
                                @endif

                                <form action="{{ route('admin.import.proses') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label font-weight-bold">Pilih File Excel / CSV</label>
                                        <input type="file" name="file" class="form-control" required>
                                        <div class="form-text text-muted">
                                            Format Kolom Excel wajib: <code>nomor_induk</code> | <code>nama</code> | <code>peran</code> | <code>kelas_jabatan</code>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Upload & Import Data</button>
                                </form>

                            </div>
                        </div>

                        <!-- Tabel Data Pemilih Terdaftar -->
                        <div class="card shadow-sm border-0 mt-4">
                            <div class="card-header bg-dark text-white">
                                Daftar Pemilih Terdaftar (Total: {{ $users->count() }})
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>No Induk</th>
                                            <th>Nama</th>
                                            <th>Peran</th>
                                            <th>Kelas/Jabatan</th>
                                            <th>Status Vote</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                        <tr>
                                            <td>{{ $user->nomor_induk }}</td>
                                            <td>{{ $user->nama }}</td>
                                            <td><span class="badge {{ $user->peran == 'guru' ? 'bg-warning' : 'bg-info' }}">{{ strtoupper($user->peran) }}</span></td>
                                            <td>{{ $user->kelas_jabatan }}</td>
                                            <td><span class="badge {{ $user->status_voted == 'sudah' ? 'bg-success' : 'bg-secondary' }}">{{ strtoupper($user->status_voted) }}</span></td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-3">Belum ada data pemilih. Silakan import file Excel/CSV.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

</body>

</html>