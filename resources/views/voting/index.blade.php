<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEMILIHAN KETUA OSIS - SMKN 1 BANJAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #550000;
            --primary-hover: #3b0000;
            --bg-canvas: #f8f6f6;
            --card-border: #e2e8f0;
        }

        body {
            background-color: var(--bg-canvas);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            min-height: 100vh;
        }

        .navbar-custom {
            background-color: var(--primary-color);
            padding: 16px 32px;
            box-shadow: 0 4px 20px rgba(85, 0, 0, 0.2);
        }

        .card-paslon {
            border: 1px solid var(--card-border);
            border-radius: 20px;
            background: #ffffff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card-paslon:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(85, 0, 0, 0.15);
            border-color: var(--primary-color);
        }

        .card-header-paslon {
            background-color: var(--primary-color);
            color: #ffffff;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            border-top-left-radius: 19px !important;
            border-top-right-radius: 19px !important;
            padding: 12px;
            text-align: center;
        }

        .img-paslon-wrapper {
            padding: 16px 16px 0 16px;
        }

        /* Foto dengan Rasio Aspek 16:9 (Landscape) */
        .img-paslon {
            width: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
            border-radius: 14px;
        }

        .paslon-names {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            text-align: center;
            line-height: 1.3;
            margin-top: 10px;
            margin-bottom: 14px;
        }

        .paslon-names .wakil-name {
            font-size: 1.05rem;
            font-weight: 700;
            color: #475569;
            display: block;
            margin-top: 2px;
        }

        .section-label {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--primary-color);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Format Teks Rapat Tanpa Spasi Enter Berlebih */
        .content-text {
            font-size: 0.85rem;
            line-height: 1.45;
            color: #475569;
            text-align: left;
            white-space: pre-line;
            margin-bottom: 0;
        }

        .btn-coblos {
            background-color: var(--primary-color);
            color: #ffffff;
            font-weight: 700;
            border-radius: 12px;
            padding: 12px;
            border: none;
            width: 100%;
            transition: all 0.2s ease;
        }

        .btn-coblos:hover {
            background-color: var(--primary-hover);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(85, 0, 0, 0.35);
        }
    </style>
</head>

<body>

    <!-- Header Navbar -->
    <nav class="navbar navbar-custom sticky-top text-white mb-4">
        <div class="container-fluid">
            <div>
                <span class="fw-bold fs-5 text-uppercase tracking-wide d-block">PEMILIHAN KETUA OSIS</span>
                <small class="opacity-75">SMKN 1 BANJAR</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <span class="d-block small opacity-75">Pemilih Terdaftar:</span>
                    <strong class="fs-6">{{ auth()->user()->nama ?? 'Fito Rizki Alwandi' }}</strong>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light rounded-pill px-3 fw-semibold">
                        <i class="bi bi-box-arrow-right me-1"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Container Layout Lebar Proporsional -->
    <div class="container-fluid px-3 px-md-5 pb-5">
        <div class="row g-4 justify-content-center">
            @foreach($kandidats as $kandidat)
            <div class="col-12 col-md-6 col-xl-4 d-flex align-items-stretch">
                <div class="card-paslon w-100">
                    <!-- Header Nomor Urut -->
                    <div class="card-header-paslon">
                        PASLON {{ $kandidat->nomor_urut }}
                    </div>

                    <!-- Foto Paslon Rasio 16:9 -->
                    <div class="img-paslon-wrapper">
                        <img src="{{ asset('storage/' . $kandidat->foto) }}" class="img-paslon" alt="Foto Paslon {{ $kandidat->nomor_urut }}">
                    </div>

                    <!-- Body Content -->
                    <div class="card-body p-4 d-flex flex-column h-100">
                        <!-- Nama Format Baris (Enter & Enter) -->
                        <div class="paslon-names">
                            <div>{{ $kandidat->nama_ketua }}</div>
                            <span class="wakil-name">& {{ $kandidat->nama_wakil }}</span>
                        </div>

                        <hr class="my-2 opacity-25">

                        <!-- Visi -->
                        <div class="mb-3">
                            <div class="section-label">
                                <i class="bi bi-eye-fill"></i> Visi:
                            </div>
                            <div class="content-text">
                                {{ trim($kandidat->visi) }}
                            </div>
                        </div>

                        <!-- Misi (List Rapat) -->
                        <div class="mb-3">
                            <div class="section-label">
                                <i class="bi bi-list-check"></i> Misi:
                            </div>
                            <div class="content-text">
                                {{ trim($kandidat->misi) }}
                            </div>
                        </div>

                        <!-- Program Kerja (Proker) -->
                        @if(!empty($kandidat->proker))
                        <div class="mb-3">
                            <div class="section-label">
                                <i class="bi bi-briefcase-fill"></i>Program Kerja:
                            </div>
                            <div class="content-text">
                                {{ trim($kandidat->proker) }}
                            </div>
                        </div>
                        @endif

                        <!-- Button Action (Stick to bottom) -->
                        <div class="mt-auto pt-3">
                            <button type="button" class="btn-coblos" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $kandidat->id }}">
                                COBLOS PASLON {{ $kandidat->nomor_urut }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Konfirmasi Coblos -->
            <div class="modal fade" id="confirmModal{{ $kandidat->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 rounded-4 shadow">
                        <div class="modal-body text-center p-4">
                            <h4 class="fw-bold mb-2">Konfirmasi Pilihan</h4>
                            <p class="text-muted small mb-4">
                                Apakah Anda yakin ingin memilih Paslon Nomor Urut <strong>{{ $kandidat->nomor_urut }}</strong>?<br>
                                <strong class="text-dark d-block mt-2">{{ $kandidat->nama_ketua }} & {{$kandidat->nama_wakil }}</strong>
                            </p>

                            <form action="{{ route('voting.simpan') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kandidat_id" value="{{ $kandidat->id }}">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-coblos px-4 rounded-3 w-auto">Ya, Saya Yakin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Script CDN Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Anti-Double Submit -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const btnSubmit = this.querySelector('button[type="submit"]');
                    if (btnSubmit) {
                        btnSubmit.disabled = true;
                        btnSubmit.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses Suara...`;
                    }
                });
            });
        });
    </script>
</body>

</html>