<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60">
    <title>DISPLAY LIVE QUICK COUNT - PEMILOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-color: #15C5D2;
            --bg-canvas: #f4f7f8;
            --card-radius: 20px;
        }

        body {
            background-color: var(--bg-canvas);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2d3748;
            min-height: 100vh;
        }

        .header-top {
            background-color: var(--brand-color);
            color: #ffffff;
            padding: 22px 40px;
            border-bottom-left-radius: 24px;
            border-bottom-right-radius: 24px;
            box-shadow: 0 10px 25px rgba(21, 197, 210, 0.2);
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .pulse-dot {
            width: 10px;
            height: 10px;
            background-color: #22c55e;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            animation: pulse-green 1.6s infinite;
        }

        @keyframes pulse-green {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 8px rgba(34, 197, 94, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
            }
        }

        .card-paslon-result {
            background: #ffffff;
            border-radius: var(--card-radius);
            border: 1px solid rgba(21, 197, 210, 0.2);
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card-paslon-result.is-leading {
            border: 2.5px solid var(--brand-color);
            background: linear-gradient(180deg, #ffffff 0%, #f4fdfd 100%);
        }

        .leader-tag {
            position: absolute;
            top: 16px;
            right: 16px;
            background-color: var(--brand-color);
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 5px 14px;
            border-radius: 50px;
            text-transform: uppercase;
        }

        .paslon-avatar {
            width: 90px;
            height: 90px;
            border-radius: 18px;
            object-fit: cover;
            border: 2px solid var(--brand-color);
        }

        .paslon-no {
            font-size: 0.85rem;
            font-weight: 800;
            color: var(--brand-color);
            text-transform: uppercase;
        }

        .paslon-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #1a202c;
        }

        .vote-count-big {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--brand-color);
            line-height: 1;
        }

        .progress-custom-bg {
            background-color: #edf2f7;
            height: 24px;
            border-radius: 50px;
            overflow: hidden;
            padding: 3px;
        }

        .progress-custom-fill {
            background: linear-gradient(90deg, #15C5D2 0%, #38ef7d 100%);
            height: 100%;
            border-radius: 50px;
            transition: width 1.2s ease;
            position: relative;
            overflow: hidden;
        }

        .progress-custom-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0) 100%);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }
    </style>
</head>

<body>

    <!-- Header Top dengan Tombol Kembali -->
    <div class="header-top d-flex justify-content-between align-items-center mb-5">
        <div class="header-title">
            <i class="bi bi-bar-chart-line-fill me-2"></i> HASIL PEROLEHAN SUARA - PEMILOS SMKN 1 BANJAR
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-light fw-bold rounded-pill text-dark px-3 shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Dashboard Admin
            </a>
            <div class="d-flex align-items-center gap-2 bg-white text-dark px-3 py-2 rounded-pill fw-bold shadow-sm">
                <span class="pulse-dot"></span>
                <span class="small text-uppercase">Live Display</span>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @php $maxVotes = $kandidats->max('votes_count'); @endphp

                @forelse($kandidats as $kandidat)
                @php
                $persentase = $totalSuaraMasuk > 0 ? round(($kandidat->votes_count / $totalSuaraMasuk) * 100, 1) : 0;
                $isLeading = ($kandidat->votes_count > 0 && $kandidat->votes_count === $maxVotes);
                @endphp

                <div class="card-paslon-result {{ $isLeading ? 'is-leading' : '' }}">
                    @if($isLeading)
                    <div class="leader-tag"><i class="bi bi-trophy-fill me-1"></i> Perolehan Tertinggi</div>
                    @endif

                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ asset('storage/' . $kandidat->foto) }}" class="paslon-avatar" alt="Foto Paslon">
                        <div>
                            <div class="paslon-no">PASLON NOMOR URUT {{ $kandidat->nomor_urut }}</div>
                            <div class="paslon-title">{{ $kandidat->nama_ketua }} & {{ $kandidat->nama_wakil }}</div>
                        </div>
                        <div class="ms-auto text-end">
                            <div class="vote-count-big">{{ number_format($kandidat->votes_count) }} <span class="fs-6 text-muted">Suara</span></div>
                            <div class="fw-bold text-dark fs-5">{{ $persentase }}%</div>
                        </div>
                    </div>

                    <div class="progress-custom-bg">
                        <div class="progress-custom-fill" style="width: {{ $persentase }}%;"></div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                    <h5 class="fw-bold text-muted">Belum ada data Paslon.</h5>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</body>

</html>