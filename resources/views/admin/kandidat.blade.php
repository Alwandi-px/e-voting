<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Paslon Pemilos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">

    <div class="container mt-4">
        <!-- Tombol Kembali ke Dashboard -->
        <div class="mb-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary fw-bold rounded-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard Admin
            </a>
        </div>
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">KELOLA DATA PASLON</h3>
                <div>
                    <a href="{{ route('admin.import') }}" class="btn btn-secondary">Data Pemilih</a>
                    <a href="{{ route('admin.quickcount') }}" class="btn btn-success fw-bold">Lihat Quick Count</a>
                </div>
            </div>

            @if(session('sukses'))
            <div class="alert alert-success mb-3">{{ session('sukses') }}</div>
            @endif

            <div class="row">
                <!-- Form Tambah Paslon -->
                <div class="col-md-5 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white fw-bold">Tambah Paslon Baru</div>
                        <div class="card-body">
                            <form action="{{ route('admin.kandidat.simpan') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label">Nomor Urut Paslon</label>
                                    <input type="number" name="nomor_urut" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Nama Calon Ketua</label>
                                    <input type="text" name="nama_ketua" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Nama Calon Wakil</label>
                                    <input type="text" name="nama_wakil" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Foto Paslon (JPG/PNG)</label>
                                    <input type="file" name="foto" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Visi</label>
                                    <textarea name="visi" class="form-control" rows="2" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Misi</label>
                                    <textarea name="misi" class="form-control" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Data Paslon</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Daftar Paslon Terdaftar -->
                <div class="col-md-7">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white fw-bold">Daftar Paslon Terdaftar</div>
                        <div class="card-body">
                            <div class="row g-3">
                                @forelse($kandidats as $kandidat)
                                <div class="col-md-6">
                                    <div class="card h-100 border text-center p-2">
                                        <span class="badge bg-dark mb-2">No. Urut {{ $kandidat->nomor_urut }}</span>
                                        <img src="{{ asset('storage/' . $kandidat->foto) }}" class="img-fluid rounded mb-2" style="max-height: 120px; object-fit: cover;">
                                        <h6 class="fw-bold text-primary mb-0">{{ $kandidat->nama_ketua }}</h6>
                                        <p class="small text-muted mb-1">& {{ $kandidat->nama_wakil }}</p>
                                    </div>
                                </div>
                                @empty
                                <p class="text-center text-muted my-3">Belum ada Paslon. Silakan input pada form di samping.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>