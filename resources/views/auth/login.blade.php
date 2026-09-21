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
            --brand-color: #550000;
            --brand-hover: #3b0000;
            --bg-canvas: #f8f6f6;
            --color-siswa: #2b4c7e;
            --color-guru: #b47d00;
        }

        body {
            background-color: var(--bg-canvas);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
        }

        .login-card {
            border: 1px solid rgba(85, 0, 0, 0.12);
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(85, 0, 0, 0.05);
            background: #ffffff;
        }

        /* Tombol Utama Login Siswa (Maroon/Deep Blue Accent) */
        .btn-primary-brand {
            background-color: var(--brand-color);
            border: none;
            color: #ffffff;
            transition: all 0.2s ease;
        }

        .btn-primary-brand:hover {
            background-color: var(--brand-hover);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(85, 0, 0, 0.3);
        }

        /* Tombol Utama Login Guru */
        .btn-guru-brand {
            background-color: var(--color-guru);
            border: none;
            color: #ffffff;
            transition: all 0.2s ease;
        }

        .btn-guru-brand:hover {
            background-color: #8c6100;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(180, 125, 0, 0.3);
        }

        /* Badge Peran Deep Tone */
        .badge-role-siswa {
            background-color: var(--color-siswa) !important;
            color: #ffffff;
        }

        .badge-role-guru {
            background-color: var(--color-guru) !important;
            color: #ffffff;
        }

        /* Focus Border Input */
        .form-control:focus {
            border-color: var(--brand-color) !important;
            box-shadow: 0 0 0 0.25rem rgba(85, 0, 0, 0.15) !important;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">

    <div class="card login-card border-0 p-2" style="width: 100%; max-width: 440px;">
        <div class="card-body p-4 text-center">

            <!-- Tombol Kembali -->
            <a href="{{ route('login') }}" class="text-decoration-none text-muted small d-flex align-items-center mb-4 text-start fw-bold">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Pilihan Peran
            </a>

            <!-- Logo Sekolah SMKN 1 Banjar -->
            <img src="{{ asset('storage/logo-smkn1banjar.png') }}" alt="Logo SMKN 1 Banjar" class="img-fluid mb-2" style="max-width: 120px;" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/9/99/Sample_User_Icon.png/100px-Sample_User_Icon.png'">

            <!-- Title Maroon -->
            <h3 class="fw-extrabold mb-1" style="color: var(--brand-color);">PEMILOS 2026</h3>
            <p class="text-muted small fw-bold text-uppercase mb-3" style="letter-spacing: 0.5px;">SMK NEGERI 1 BANJAR</p>

            <!-- Badge Peran -->
            <span class="badge {{ $role == 'guru' ? 'badge-role-guru' : 'badge-role-siswa' }} mb-4 px-3 py-2 text-uppercase font-monospace rounded-pill fs-6">
                LOGIN {{ $role }}
            </span>

            <!-- Alert Error -->
            @if(session('gagal'))
            <div class="alert alert-danger text-start small mb-4 rounded-3 border-0 shadow-sm" role="alert">
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
                    <input type="text" name="nomor_induk" class="form-control form-control-lg text-center fw-bold rounded-3 shadow-sm py-3"
                        placeholder="{{ $role == 'guru' ? 'Contoh: 0009876543218' : 'Contoh: 0061234561' }}" autofocus required style="border-color: rgba(85, 0, 0, 0.25);">
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn {{ $role == 'guru' ? 'btn-guru-brand' : 'btn-primary-brand' }} btn-lg w-100 fw-bold rounded-3 shadow-sm py-3">
                    Masuk ke Bilik Suara <i class="bi bi-box-arrow-in-right ms-1"></i>
                </button>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>