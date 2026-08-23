<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PEMILOS SMKN 1 Banjar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --brand-color: #15C5D2;
        }

        body {
            background-color: #f4f7f8;
            font-family: sans-serif;
        }

        .header-top {
            background-color: var(--brand-color);
            color: white;
            padding: 20px 40px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .metric-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(21, 197, 210, 0.2);
        }

        .metric-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: #e8f9fa;
            color: var(--brand-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="header-top mb-4 shadow-sm">
        <h3 class="fw-bold mb-0"><i class="bi bi-speedometer2 me-2"></i> DASHBOARD ADMIN PEMILOS</h3>
    </div>

    <div class="container pb-5">
        <!-- Tombol Navigasi -->
        <div class="d-flex gap-2 mb-4">
            <a href="{{ route('admin.quickcount') }}" target="_blank" class="btn btn-primary fw-bold text-white px-4 py-2" style="background-color: var(--brand-color); border:none;">
                <i class="bi bi-tv me-1"></i> Buka Layar Display Proyektor
            </a>
            <a href="{{ route('admin.import') }}" class="btn btn-outline-secondary fw-bold px-3 py-2">
                <i class="bi bi-file-earmark-excel me-1"></i> Data Pemilih
            </a>
            <a href="{{ route('admin.kandidat') }}" class="btn btn-outline-secondary fw-bold px-3 py-2">
                <i class="bi bi-people me-1"></i> Kelola Paslon
            </a>
        </div>

        <!-- Kartu Statistik DPT -->
        <h5 class="fw-bold text-secondary mb-3">RINGKASAN STATISTIK PEMILIH</h5>
        <div class="row g-3">
            <div class="col-md-3">
                <div class="metric-card shadow-sm">
                    <div class="metric-icon"><i class="bi bi-people-fill"></i></div>
                    <h2 class="fw-bold mb-0">{{ number_format($totalPemilih) }}</h2>
                    <small class="text-muted text-uppercase fw-bold">Total DPT (Pemilih)</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card shadow-sm">
                    <div class="metric-icon" style="background: #dcfce7; color: #16a34a;"><i class="bi bi-check-circle-fill"></i></div>
                    <h2 class="fw-bold mb-0">{{ number_format($totalSuaraMasuk) }}</h2>
                    <small class="text-muted text-uppercase fw-bold">Suara Masuk</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card shadow-sm">
                    <div class="metric-icon" style="background: #fee2e2; color: #dc2626;"><i class="bi bi-clock-history"></i></div>
                    <h2 class="fw-bold mb-0">{{ number_format($totalBelumVote) }}</h2>
                    <small class="text-muted text-uppercase fw-bold">Belum Memilih</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card shadow-sm">
                    <div class="metric-icon" style="background: #e0f2fe; color: #0284c7;"><i class="bi bi-pie-chart-fill"></i></div>
                    <h2 class="fw-bold mb-0">{{ $persentaseMasuk }}%</h2>
                    <small class="text-muted text-uppercase fw-bold">Partisipasi Suara</small>
                </div>
            </div>
        </div>
    </div>

</body>

</html>