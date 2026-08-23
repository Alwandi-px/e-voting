<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login {{ strtoupper($role) }} - PEMILOS SMKN 1 Banjar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-color: #15C5D2;
            --brand-hover: #11aab7;
        }

        body {
            background-color: #f4f7f8;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2d3748;
        }

        .login-card {
            border: 1px solid rgba(21, 197, 210, 0.2);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }

        .btn-primary-brand {
            background-color: var(--brand-color);
            border: none;
            color: #ffffff;
            transition: all 0.2s ease;
        }

        .btn-primary-brand:hover {
            background-color: var(--brand-hover);
            color: #ffffff;
        }

        .badge-role-siswa {
            background-color: var(--brand-color) !important;
            color: #ffffff;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">

    <div class="card login-card border-0 p-2" style="width: 100%; max-width: 420px;">
        <div class="card-body p-4 text-center">

            <!-- Tombol Kembali -->
            <a href="{{ route('login') }}" class="text-decoration-none text-muted small d-flex align-items-center mb-3 text-start fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Pilihan Peran
            </a>

            <!-- Logo Sekolah SMKN 1 Banjar -->
            <img src="{{ asset('storage/images/logo.png') }}" alt="Logo SMKN 1 Banjar" class="img-fluid" style="max-width: 105px;">

            <!-- Title -->
            <h3 class="fw-extrabold text-dark mb-1" style="color: #1a202c;">PEMILOS 2026</h3>
            <p class="text-muted small fw-bold text-uppercase mb-3" style="letter-spacing: 0.5px;">SMKN 1 BANJAR</p>

            <!-- Badge Peran -->
            <span class="badge {{ $role == 'guru' ? 'bg-warning text-dark' : 'badge-role-siswa' }} mb-4 px-3 py-2 text-uppercase font-monospace rounded-pill">
                LOGIN {{ $role }}
            </span>

            <!-- Alert Error -->
            @if(session('gagal'))
            <div class="alert alert-danger text-start small mb-3 rounded-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('gagal') }}
            </div>
            @endif

            <!-- Form Input Login -->
            <form action="{{ route('login.proses') }}" method="POST">
                @csrf
                <input type="hidden" name="peran" value="{{ $role }}">

                <div class="mb-4 text-start">
                    <label class="form-label fw-bold text-secondary small">
                        {{ $role == 'guru' ? 'Masukkan Kode Guru / NIP' : 'Masukkan NISN Siswa' }}
                    </label>
                    <input type="text" name="nomor_induk" class="form-control form-control-lg text-center fw-bold rounded-3 shadow-sm"
                        placeholder="{{ $role == 'guru' ? 'Contoh: G001' : 'Contoh: 0061234561' }}" autofocus required style="border-color: rgba(21, 197, 210, 0.4);">
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn {{ $role == 'guru' ? 'btn-warning text-dark' : 'btn-primary-brand' }} btn-lg w-100 fw-bold rounded-3 shadow-sm">
                    Masuk ke Bilik Suara <i class="bi bi-box-arrow-in-right ms-1"></i>
                </button>
            </form>

        </div>
    </div>

</body>

</html>