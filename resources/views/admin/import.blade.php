<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Pemilih - Admin PEMILOS</title>
    <!-- Bootstrap 5 CSS & Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .badge-guru {
            background-color: #ffc107;
            color: #000;
        }

        .badge-siswa {
            background-color: #0dcaf0;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="container py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Kelola Data Pemilih</h3>
                <p class="text-muted mb-0">Import data siswa & guru dari file Excel atau kosongkan data pemilih.</p>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm me-2">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
                <!-- Tombol Trigger Reset Modal -->
                <button type="button" class="btn btn-outline-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#resetModal">
                    <i class="bi bi-trash3-fill me-1"></i> Reset Data Pemilih
                </button>
            </div>
        </div>

        <!-- Alert Success / Fail -->
        @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('gagal'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('gagal') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Card Form Import Excel -->
        <div class="card mb-4">
            <div class="card-body p-4">
                <h5 class="fw-semibold mb-3"><i class="bi bi-file-earmark-excel text-success me-2"></i>Import Data Via Excel</h5>

                <form action="{{ route('admin.import.excel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-9">
                            <label for="file_excel" class="form-label text-muted small">Pilih File Spreadsheet (.xlsx / .xls)</label>
                            <input type="file" name="file" id="file_excel" class="form-control" required accept=".xlsx, .xls">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100 d-flex justify-content-center align-items-center gap-2">
                                <i class="bi bi-cloud-upload-fill"></i>
                                <span>Upload & Import</span>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="mt-3">
                    <small class="text-muted">* Format kolom Excel yang didukung: <code>nomor_induk / nisn</code>, <code>nama</code>, <code>peran</code>, <code>kelas_jabatan</code>.</small>
                </div>
            </div>
        </div>

        <!-- Card Tabel Data Pemilih dengan Filter -->
        <div class="card">
            <div class="card-body p-4">

                <!-- Header & Form Filter -->
                <!-- Form Filter & Searching -->
                <form method="GET" action="{{ route('admin.import') }}" class="row g-2 align-items-center mb-3">
                    <!-- Input Search -->
                    <div class="col-md-5 col-12">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                placeholder="Cari Nama, NISN, atau Kelas..."
                                value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Filter Peran -->
                    <div class="col-md-3 col-6">
                        <select name="peran" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Semua Peran (Guru & Siswa) --</option>
                            <option value="siswa" {{ request('peran') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="guru" {{ request('peran') == 'guru' ? 'selected' : '' }}>Guru / Staf</option>
                        </select>
                    </div>

                    <!-- Filter Status Vote -->
                    <div class="col-md-3 col-6">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Semua Status Vote --</option>
                            <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Memilih</option>
                            <option value="sudah" {{ request('status') == 'sudah' ? 'selected' : '' }}>Sudah Memilih</option>
                        </select>
                    </div>

                    <!-- Tombol Submit / Reset Search -->
                    <div class="col-md-1 col-12 d-grid">
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-filter me-1"></i> Cari
                        </button>
                    </div>
                </form>

                <!-- Notifikasi Hasil Pencarian (Jika sedang mengetik pencarian) -->
                @if(request('search'))
                <div class="d-flex justify-content-between align-items-center mb-3 alert alert-light border">
                    <small class="text-muted">
                        Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                    </small>
                    <a href="{{ route('admin.import') }}" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-x-circle me-1"></i> Reset Cari
                    </a>
                </div>
                @endif

                <!-- Reset Filter Button -->
                @if(request('peran') || request('status'))
                <div class="col-md-1">
                    <a href="{{ route('admin.import') }}" class="btn btn-light w-100 text-danger" title="Reset Filter">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                </div>
                @endif
                </form>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>No. Induk / NISN</th>
                                <th>Nama Lengkap</th>
                                <th>Peran</th>
                                <th>Kelas / Jabatan</th>
                                <th>Status Vote</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $user->nomor_induk }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>
                                    <span class="badge {{ strtolower($user->peran) == 'guru' ? 'badge-guru' : 'badge-siswa' }} text-uppercase">
                                        {{ $user->peran }}
                                    </span>
                                </td>
                                <td>{{ $user->kelas_jabatan }}</td>
                                <td>
                                    @if(strtolower($user->status_voted) == 'sudah')
                                    <span class="badge bg-success">SUDAH</span>
                                    @else
                                    <span class="badge bg-secondary">BELUM</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Data tidak ditemukan sesuai filter yang dipilih.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Modal Konfirmasi Reset Data -->
        <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow rounded-4">
                    <div class="modal-body text-center p-4">
                        <div class="text-danger mb-3">
                            <i class="bi bi-exclamation-triangle-fill display-3"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Hapus Semua Pemilih?</h4>
                        <p class="text-muted small mb-4">Tindakan ini akan menghapus seluruh data <strong>Siswa</strong> dan <strong>Guru</strong> dari sistem. Data yang dihapus tidak dapat dikembalikan!</p>

                        <form action="{{ route('admin.pemilih.reset') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-light px-4 py-2 rounded-3" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger px-4 py-2 rounded-3">Ya, Reset Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap 5 JS Bundle (Wajib untuk modal & alert) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>