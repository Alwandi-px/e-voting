<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Paslon - Admin PEMILOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-color: #550000;
            --brand-hover: #3b0000;
            --bg-canvas: #f8f6f6;
            --card-radius: 16px;
        }

        body {
            background-color: var(--bg-canvas);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            min-height: 100vh;
        }

        .header-top {
            background-color: var(--brand-color);
            color: #ffffff;
            padding: 20px 40px;
            border-bottom-left-radius: 24px;
            border-bottom-right-radius: 24px;
            box-shadow: 0 8px 20px rgba(85, 0, 0, 0.2);
        }

        .card-custom {
            background: #ffffff;
            border-radius: var(--card-radius);
            border: 1px solid rgba(85, 0, 0, 0.12);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .card-header-maroon {
            background-color: var(--brand-color);
            color: #ffffff;
            font-weight: 700;
            padding: 14px 20px;
        }

        .btn-maroon {
            background-color: var(--brand-color);
            color: #ffffff;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            transition: all 0.2s;
        }

        .btn-maroon:hover {
            background-color: var(--brand-hover);
            color: #ffffff;
        }

        .paslon-card-img {
            height: 180px;
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>

<body>

    <!-- Header Navbar -->
    <div class="header-top d-flex justify-content-between align-items-center mb-4">
        <div class="fw-bold fs-4 text-uppercase">
            <i class="bi bi-people-fill me-2"></i> Kelola Data Paslon
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-light fw-bold rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <a href="{{ route('admin.quickcount') }}" class="btn btn-sm btn-outline-light rounded-pill px-3" target="_blank">
                <i class="bi bi-projector-fill me-1"></i> Quick Count
            </a>
        </div>
    </div>

    <div class="container pb-5">

        @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row g-4">
            <!-- Form Tambah Paslon -->
            <div class="col-lg-5">
                <div class="card-custom">
                    <div class="card-header-maroon">
                        <i class="bi bi-plus-circle-fill me-2"></i>Tambah Paslon Baru
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.kandidat.simpan') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Nomor Urut Paslon</label>
                                <input type="number" name="nomor_urut" class="form-control" required placeholder="Contoh: 1">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Nama Calon Ketua</label>
                                <input type="text" name="nama_ketua" class="form-control" required placeholder="Nama Ketua">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Nama Calon Wakil</label>
                                <input type="text" name="nama_wakil" class="form-control" required placeholder="Nama Wakil">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Foto Paslon (JPG/PNG)</label>
                                <input type="file" name="foto" class="form-control" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Visi</label>
                                <textarea name="visi" class="form-control" rows="2" required placeholder="Tuliskan visi paslon..."></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold small text-muted">Misi</label>
                                <textarea name="misi" class="form-control" rows="4" required placeholder="Tuliskan poin-poin misi paslon..."></textarea>
                            </div>
                            <!-- Input Program Kerja (Taruh di bawah Misi) -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Program Kerja Unggulan</label>
                                <textarea name="proja" class="form-control" rows="3" placeholder="Contoh: 1. Pensi Tahunan&#10;2. E-Mading Sekolah">{{ $kandidat->proja ?? old('proja') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-maroon w-100">
                                <i class="bi bi-save-fill me-1"></i> Simpan Data Paslon
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- List Paslon Terdaftar -->
            <div class="col-lg-7">
                <div class="card-custom">
                    <div class="card-header-maroon d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-grid-fill me-2"></i>Daftar Paslon Terdaftar</span>
                        <span class="badge bg-light text-dark fs-6">{{ $kandidats->count() }} Paslon</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @forelse($kandidats as $kandidat)
                            <div class="col-md-6">
                                <div class="border rounded-4 overflow-hidden shadow-sm h-100 d-flex flex-column bg-white">
                                    <div class="bg-dark text-white text-center py-2 fw-bold small" style="background-color: #550000 !important;">
                                        NO. URUT {{ $kandidat->nomor_urut }}
                                    </div>
                                    <img src="{{ asset('storage/' . $kandidat->foto) }}" class="paslon-card-img" alt="Foto Paslon">
                                    <div class="p-3 text-center d-flex flex-column justify-content-between flex-grow-1">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $kandidat->nama_ketua }}</h6>
                                            <small class="text-muted d-block mb-3">& {{ $kandidat->nama_wakil }}</small>
                                        </div>
                                        <!-- Action Buttons (Edit & Delete) -->
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-warning w-100 fw-semibold" data-bs-toggle="modal" data-bs-target="#editModal{{ $kandidat->id }}">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger w-100 fw-semibold" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $kandidat->id }}">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Edit Paslon -->
                            <div class="modal fade" id="editModal{{ $kandidat->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-4 shadow">
                                        <div class="modal-header text-white" style="background-color: #550000;">
                                            <h5 class="modal-title fw-bold">Edit Paslon No. {{ $kandidat->nomor_urut }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.kandidat.update', $kandidat->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body p-4">
                                                <div class="mb-3 text-start">
                                                    <label class="form-label fw-semibold small text-muted">Nomor Urut</label>
                                                    <input type="number" name="nomor_urut" class="form-control" value="{{ $kandidat->nomor_urut }}" required>
                                                </div>
                                                <div class="mb-3 text-start">
                                                    <label class="form-label fw-semibold small text-muted">Nama Ketua</label>
                                                    <input type="text" name="nama_ketua" class="form-control" value="{{ $kandidat->nama_ketua }}" required>
                                                </div>
                                                <div class="mb-3 text-start">
                                                    <label class="form-label fw-semibold small text-muted">Nama Wakil</label>
                                                    <input type="text" name="nama_wakil" class="form-control" value="{{ $kandidat->nama_wakil }}" required>
                                                </div>
                                                <div class="mb-3 text-start">
                                                    <label class="form-label fw-semibold small text-muted">Ganti Foto (Opsional)</label>
                                                    <input type="file" name="foto" class="form-control" accept="image/*">
                                                </div>
                                                <div class="mb-3 text-start">
                                                    <label class="form-label fw-semibold small text-muted">Visi</label>
                                                    <textarea name="visi" class="form-control" rows="2" required>{{ $kandidat->visi }}</textarea>
                                                </div>
                                                <div class="mb-3 text-start">
                                                    <label class="form-label fw-semibold small text-muted">Misi</label>
                                                    <textarea name="misi" class="form-control" rows="4" required>{{ $kandidat->misi }}</textarea>
                                                </div>
                                                <!-- Textarea Proker di Modal Edit Paslon -->
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Program Kerja (Proker)</label>
                                                    <textarea name="proker" class="form-control" rows="3" placeholder="Tuliskan poin-poin proker paslon...">{{ old('proker', $kandidat->proker) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light border-0">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-maroon px-4">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Hapus Paslon -->
                            <div class="modal fade" id="deleteModal{{ $kandidat->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-4 shadow">
                                        <div class="modal-body text-center p-4">
                                            <i class="bi bi-exclamation-triangle-fill text-danger display-4 mb-3 d-block"></i>
                                            <h5 class="fw-bold mb-2">Hapus Paslon No. {{ $kandidat->nomor_urut }}?</h5>
                                            <p class="text-muted small mb-4">Data paslon <strong>{{ $kandidat->nama_ketua }} & {{ $kandidat->nama_wakil }}</strong> akan dihapus permanen beserta foto paslonnya.</p>
                                            <form action="{{ route('admin.kandidat.hapus', $kandidat->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <div class="col-12 text-center py-5 text-muted">
                                <i class="bi bi-inbox display-4 d-block mb-2"></i> Belum ada data paslon terdaftar.
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>