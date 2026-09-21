<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Portal PEMILOS 2026 - SMKN 1 BANJAR</title>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        .portal-wrapper {
            width: 100%;
            max-width: 820px;
            padding: 20px;
        }

        /* Logo Diperbesar & Touch Friendly */
        .school-logo {
            width: 140px;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba(85, 0, 0, 0.15));
            transition: transform 0.3s ease;
        }

        .school-logo:hover {
            transform: scale(1.05);
        }

        .portal-title {
            color: var(--brand-color);
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-top: 16px;
            margin-bottom: 2px;
        }

        .portal-subtitle {
            font-weight: 700;
            color: #64748b;
            letter-spacing: 1px;
            font-size: 0.95rem;
        }

        .role-section-label {
            font-size: 0.85rem;
            font-weight: 800;
            color: #94a3b8;
            letter-spacing: 1.5px;
            margin-top: 24px;
            margin-bottom: 20px;
        }

        /* Card Tombol Diperbesar & Responsive */
        .card-role-choice {
            background: #ffffff;
            border: 2px solid rgba(85, 0, 0, 0.1);
            border-radius: 24px;
            padding: 36px 28px;
            text-decoration: none;
            color: #1e293b;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
            height: 100%;
            touch-action: manipulation;
        }

        /* Hover Effect Siswa */
        .card-role-siswa:hover {
            border-color: var(--color-siswa);
            transform: translateY(-6px);
            box-shadow: 0 16px 32px rgba(43, 76, 126, 0.18);
        }

        /* Hover Effect Guru */
        .card-role-guru:hover {
            border-color: var(--color-guru);
            transform: translateY(-6px);
            box-shadow: 0 16px 32px rgba(180, 125, 0, 0.18);
        }

        /* Icon Box Diperbesar */
        .icon-role-box {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 18px;
            transition: transform 0.3s ease;
        }

        .card-role-choice:hover .icon-role-box {
            transform: scale(1.1);
        }

        .role-name {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .role-desc {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="portal-wrapper text-center">
        <!-- Header Branding & Logo Diperbesar -->
        <div class="mb-2">
            <img src="{{ asset('storage/images/logo.png') }}" alt="Logo SMKN 1 Banjar" class="img-fluid" style="max-width: 155px;">
        </div>
        <h1 class="portal-title">PEMILOS 2026</h1>
        <div class="portal-subtitle text-uppercase">SMK Negeri 1 Banjar</div>

        <!-- NOTIFIKASI SUKSES VOTE -->
        @if(session('sukses_vote'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 text-start p-3 my-4 d-flex align-items-center gap-3">
            <i class="bi bi-check-circle-fill text-success fs-2"></i>
            <div>
                <h6 class="fw-bold mb-1 text-success">Pencoblosan Berhasil!</h6>
                <small class="text-secondary">{{ session('sukses_vote') }}</small>
            </div>
        </div>
        @endif

        <!-- NOTIFIKASI GAGAL / ERROR -->
        @if(session('gagal'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 text-start p-3 my-4 d-flex align-items-center gap-3">
            <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
            <div>
                <h6 class="fw-bold mb-1 text-danger">Akses Ditolak / Gagal!</h6>
                <small class="text-secondary">{{ session('gagal') }}</small>
            </div>
        </div>
        @endif

        <div class="role-section-label">MASUK SEBAGAI:</div>

        <!-- Tombol Pilihan Peran Diperbesar -->
        <div class="row g-4 justify-content-center">
            <!-- Pilihan Siswa -->
            <div class="col-md-5 col-sm-6 col-12">
                <a href="{{ route('login.role', 'siswa') }}" class="card-role-choice card-role-siswa">
                    <div class="icon-role-box" style="background-color: rgba(43, 76, 126, 0.1); color: var(--color-siswa);">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div class="role-name" style="color: var(--color-siswa);">SISWA</div>
                    <div class="role-desc">Masuk dengan NISN / Nomor Induk</div>
                </a>
            </div>

            <!-- Pilihan Guru -->
            <div class="col-md-5 col-sm-6 col-12">
                <a href="{{ route('login.role', 'guru') }}" class="card-role-choice card-role-guru">
                    <div class="icon-role-box" style="background-color: rgba(180, 125, 0, 0.1); color: var(--color-guru);">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                    <div class="role-name" style="color: var(--color-guru);">GURU / STAF</div>
                    <div class="role-desc">Masuk dengan Kode Akun / NIP</div>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>