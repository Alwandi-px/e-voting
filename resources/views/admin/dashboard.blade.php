<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    <title>DASHBOARD ADMIN - PEMILOS SMKN 1 BANJAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-color: #550000;
            --brand-hover: #3b0000;
            --bg-canvas: #f8f6f6;
            --card-radius: 16px;

            --color-siswa: #2b4c7e;
            --color-guru: #b47d00;
            --color-suara-masuk: #1b7a43;
            --color-belum: #8c4a00;
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

        .header-title {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .card-stat {
            background: #ffffff;
            border-radius: var(--card-radius);
            border: 1px solid rgba(85, 0, 0, 0.12);
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease;
        }

        .card-stat:hover {
            transform: translateY(-3px);
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .btn-action {
            background-color: #ffffff;
            color: #1e293b;
            border: 1px solid #e2e8f0;
            font-weight: 700;
            padding: 10px 18px;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .btn-action:hover,
        .btn-action.active {
            background-color: var(--brand-color);
            color: #ffffff;
            border-color: var(--brand-color);
        }

        .badge-siswa-deep {
            background-color: var(--color-siswa) !important;
            color: #ffffff !important;
        }

        .badge-guru-deep {
            background-color: var(--color-guru) !important;
            color: #ffffff !important;
        }

        .progress-bar-siswa {
            background-color: var(--color-siswa) !important;
        }

        .progress-bar-guru {
            background-color: var(--color-guru) !important;
        }
    </style>
</head>

<body>

    <!-- Header Navbar -->
    <div class="header-top d-flex justify-content-between align-items-center mb-4">
        <div class="header-title">
            <i class="bi bi-speedometer2 me-2"></i> DASHBOARD ADMIN PEMILOS
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-light rounded-pill px-3 fw-bold">
                <i class="bi bi-box-arrow-right me-1"></i> Keluar
            </button>
        </form>
    </div>

    <div class="container pb-5">
        <!-- Alert Flash Message -->
        @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('gagal'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('gagal') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Navigation Action Buttons & Tombol Reset Suara Single -->
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
            <a href="{{ route('admin.quickcount') }}" class="btn btn-action active" target="_blank">
                <i class="bi bi-projector-fill me-2"></i> Buka Layar Display Proyektor
            </a>
            <a href="{{ route('admin.import') }}" class="btn btn-action">
                <i class="bi bi-file-earmark-excel me-2"></i> Data Pemilih
            </a>
            <a href="{{ route('admin.kandidat') }}" class="btn btn-action">
                <i class="bi bi-people-fill me-2"></i> Kelola Paslon
            </a>

            <!-- Tombol Pemicu Modal Reset Suara (Satu Saja) -->
            <button type="button" class="btn btn-danger rounded-3 fw-bold px-3 py-2 ms-md-auto" data-bs-toggle="modal" data-bs-target="#modalResetSuara">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Suara
            </button>
        </div>

        <!-- Modal Konfirmasi Reset Suara -->
        <div class="modal fade" id="modalResetSuara" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-body text-center p-4">
                        <i class="bi bi-exclamation-triangle-fill text-warning display-4 mb-3 d-block"></i>
                        <h4 class="fw-bold mb-2">Reset Seluruh Hasil Suara?</h4>
                        <p class="text-muted small mb-4">
                            Tindakan ini akan mengosongkan perolehan suara (menjadi 0) dan mengembalikan status semua pemilih menjadi <strong>Belum Memilih</strong>.
                        </p>

                        <form action="{{ route('admin.resetSuara') }}" method="POST">
                            @csrf
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger px-4 rounded-3 fw-bold">Ya, Reset Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan Statistik Utama -->
        <h6 class="fw-bold text-muted text-uppercase tracking-wide mb-3">Ringkasan Statistik Pemilih</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card-stat d-flex align-items-center gap-3">
                    <div class="icon-box" style="background-color: rgba(43, 76, 126, 0.1); color: #2b4c7e;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-extrabold text-dark line-height-1">{{ $totalPemilih }}</div>
                        <small class="text-muted fw-semibold">TOTAL DPT (PEMILIH)</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card-stat d-flex align-items-center gap-3">
                    <div class="icon-box" style="background-color: rgba(27, 122, 67, 0.1); color: #1b7a43;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-extrabold text-dark line-height-1">{{ $totalSuaraMasuk }}</div>
                        <small class="text-muted fw-semibold">SUARA MASUK</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card-stat d-flex align-items-center gap-3">
                    <div class="icon-box" style="background-color: rgba(140, 74, 0, 0.1); color: #8c4a00;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-extrabold text-dark line-height-1">{{ $totalBelumVote }}</div>
                        <small class="text-muted fw-semibold">BELUM MEMILIH</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card-stat d-flex align-items-center gap-3">
                    <div class="icon-box" style="background-color: rgba(85, 0, 0, 0.1); color: #550000;">
                        <i class="bi bi-pie-chart-fill"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-extrabold text-dark line-height-1">{{ $persentaseMasuk }}%</div>
                        <small class="text-muted fw-semibold">PARTISIPASI SUARA</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section: Rincian Partisipasi & Log Realtime -->
        <div class="row g-4">
            <!-- Rincian Guru vs Siswa -->
            <div class="col-lg-6">
                <div class="card-stat h-100">
                    <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart-steps me-2" style="color: #550000;"></i>Rincian Partisipasi Per Sektor</h6>

                    <!-- Progres Guru -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold">Guru & Staf</span>
                            <span class="fw-bold">{{ $guruVoted }} / {{ $guruTotal }} Suara</span>
                        </div>
                        @php $persenGuru = $guruTotal > 0 ? round(($guruVoted / $guruTotal) * 100, 1) : 0; @endphp
                        <div class="progress" style="height: 12px; border-radius: 10px; background-color: #f1f3f5;">
                            <div class="progress-bar progress-bar-guru" role="progressbar" style="width: {{ $persenGuru }}%;"></div>
                        </div>
                    </div>

                    <!-- Progres Siswa -->
                    <div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold">Siswa</span>
                            <span class="fw-bold">{{ $siswaVoted }} / {{ $siswaTotal }} Suara</span>
                        </div>
                        @php $persenSiswa = $siswaTotal > 0 ? round(($siswaVoted / $siswaTotal) * 100, 1) : 0; @endphp
                        <div class="progress" style="height: 12px; border-radius: 10px; background-color: #f1f3f5;">
                            <div class="progress-bar progress-bar-siswa" role="progressbar" style="width: {{ $persenSiswa }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aktivitas Vote Terbaru -->
            <div class="col-lg-6">
                <div class="card-stat h-100">
                    <h6 class="fw-bold mb-3"><i class="bi bi-activity me-2" style="color: #1b7a43;"></i>Aktivitas Voting Terbaru</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Pemilih</th>
                                    <th>Peran</th>
                                    <th>Waktu Vote</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentVotes as $vote)
                                <tr>
                                    <td class="fw-semibold">Seseorang</td>
                                    <td>
                                        <span class="badge badge-siswa-deep px-2 py-1">
                                            SISWA
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ $vote->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">Belum ada aktivitas voting.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Wajib: Script JS Bootstrap untuk Modal & Alert -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>