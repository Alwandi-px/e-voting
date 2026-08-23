<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal PEMILOS - SMKN 1 Banjar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-color: #15C5D2;
            --brand-hover: #11aab7;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card-role {
            background: #ffffff;
            border: 1px solid rgba(21, 197, 210, 0.2);
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            color: inherit;
            display: block;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .login-card-role:hover {
            transform: translateY(-5px);
            border-color: var(--brand-color);
            box-shadow: 0 12px 25px rgba(21, 197, 210, 0.15);
            color: inherit;
        }

        .role-icon {
            font-size: 2.5rem;
            color: var(--brand-color);
            margin-bottom: 12px;
        }

        .brand-text {
            color: var(--brand-color);
            font-weight: 800;
        }

        .logo-school {
            width: 110px;
            height: auto;
            object-fit: contain;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">

                <!-- Logo Sekolah SMKN 1 Banjar -->
                <div class="mb-3 text-center">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="Logo SMKN 1 Banjar" class="img-fluid" style="max-width: 105px;">
                </div>

                <!-- Judul Portal -->
                <h2 class="brand-text fs-3 mb-1">PEMILOS 2026</h2>
                <p class="text-secondary fw-semibold small text-uppercase mb-4" style="letter-spacing: 1px;">SMKN 1 BANJAR</p>

                <!-- Alert Flash Message jika ada -->
                @if(session('sukses'))
                <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4 py-3 fw-medium">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('sukses') }}
                </div>
                @endif

                <!-- Pilihan Akses Masuk -->
                <h6 class="fw-bold text-muted text-uppercase mb-3" style="letter-spacing: 0.5px;">MASUK SEBAGAI:</h6>

                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('login.role', 'siswa') }}" class="login-card-role">
                            <div class="role-icon"><i class="bi bi-person-badge-fill"></i></div>
                            <h5 class="fw-bold mb-1">SISWA</h5>
                            <p class="text-muted small mb-0">Masuk dengan NISN</p>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('login.role', 'guru') }}" class="login-card-role">
                            <div class="role-icon" style="color: #f59e0b;"><i class="bi bi-person-workspace"></i></div>
                            <h5 class="fw-bold mb-1">GURU</h5>
                            <p class="text-muted small mb-0">Masuk dengan Kode / NIP</p>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>