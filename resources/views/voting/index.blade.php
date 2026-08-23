<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemilihan Ketua OSIS SMKN 1 Banjar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --brand-color: #15C5D2;
            --brand-hover: #11aab7;
            --card-radius: 18px;
            --inner-radius: 12px;
        }

        body {
            background-color: #f4f7f8;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #2d3748;
        }

        /* Top Header Smooth */
        .header-top {
            background-color: var(--brand-color);
            color: #ffffff;
            padding: 20px 40px;
            border-bottom-left-radius: 24px;
            border-bottom-right-radius: 24px;
            box-shadow: 0 10px 25px rgba(21, 197, 210, 0.15);
        }

        .header-title {
            font-size: 1.35rem;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .pemilih-info {
            text-align: right;
            font-size: 1.05rem;
        }

        /* Card Paslon Modern & Smooth */
        .card-paslon {
            border: 1px solid rgba(21, 197, 210, 0.2);
            border-radius: var(--card-radius);
            background-color: #ffffff;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
        }

        .card-paslon:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 30px rgba(21, 197, 210, 0.15);
            border-color: var(--brand-color);
        }

        .card-paslon-header {
            background-color: var(--brand-color);
            color: #ffffff;
            font-weight: 800;
            font-size: 1.25rem;
            text-align: center;
            padding: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .paslon-img-container {
            padding: 12px;
            background-color: #ffffff;
        }

        .paslon-img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            display: block;
            border-radius: var(--inner-radius);
        }

        .paslon-body {
            padding: 18px;
            flex-grow: 1;
        }

        .paslon-names {
            font-weight: 800;
            font-size: 1.15rem;
            text-align: center;
            margin-bottom: 16px;
            color: #1a202c;
        }

        .visi-misi-title {
            font-weight: 700;
            font-size: 0.95rem;
            margin-top: 8px;
            margin-bottom: 3px;
            color: #2d3748;
        }

        .visi-misi-text {
            font-size: 0.88rem;
            color: #4a5568;
            margin-bottom: 12px;
            white-space: pre-line;
            line-height: 1.5;
        }

        /* Button Action Rounded */
        .card-paslon-footer {
            padding: 14px 18px 18px 18px;
            background-color: #ffffff;
        }

        .btn-coblos {
            background-color: var(--brand-color);
            color: #ffffff;
            font-weight: 800;
            font-size: 1.05rem;
            border: none;
            border-radius: var(--inner-radius);
            padding: 12px;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: background-color 0.2s ease, transform 0.1s ease;
            box-shadow: 0 4px 12px rgba(21, 197, 210, 0.3);
        }

        .btn-coblos:hover {
            background-color: var(--brand-hover);
            color: #ffffff;
            transform: scale(0.99);
        }

        .btn-coblos:active {
            transform: scale(0.97);
        }
    </style>
</head>

<body>

    <!-- Header Atas dengan Tombol Logout -->
    <div class="header-top d-flex justify-content-between align-items-center mb-5">
        <div class="header-title">
            PEMILIHAN KETUA<br>
            OSIS SMKN 1 BANJAR
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="pemilih-info fw-bold">
                Pemilih : <span class="fw-bold">{{ $user->nama }}</span>
                <small class="d-block fw-normal fs-6 text-white-50">{{ strtoupper($user->kelas_jabatan) }}</small>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light fw-bold rounded-pill px-3 ms-2">
                    <i class="bi bi-box-arrow-right me-1"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center g-4">
            @forelse($kandidats as $kandidat)
            <div class="col-md-4">
                <div class="card-paslon">
                    <!-- Header Card (PASLON 1, 2, 3) -->
                    <div class="card-paslon-header">
                        PASLON {{ $kandidat->nomor_urut }}
                    </div>

                    <!-- Container Foto Paslon Smooth Radius -->
                    <div class="paslon-img-container">
                        <img src="{{ asset('storage/' . $kandidat->foto) }}" class="paslon-img" alt="Foto Paslon">
                    </div>

                    <!-- Nama & Visi Misi -->
                    <div class="paslon-body">
                        <div class="paslon-names">
                            {{ $kandidat->nama_ketua }} & {{ $kandidat->nama_wakil }}
                        </div>

                        <div class="visi-misi-title"><i class="bi bi-eye-fill me-1 text-info"></i> Visi:</div>
                        <div class="visi-misi-text">{{ $kandidat->visi }}</div>

                        <div class="visi-misi-title"><i class="bi bi-list-check me-1 text-info"></i> Misi:</div>
                        <div class="visi-misi-text">{{ $kandidat->misi }}</div>
                    </div>

                    <!-- Tombol Coblos dengan Pop-up Custom SweetAlert2 -->
                    <div class="card-paslon-footer">
                        <form id="form-vote-{{ $kandidat->id }}" action="{{ route('voting.simpan') }}" method="POST">
                            @csrf
                            <input type="hidden" name="kandidat_id" value="{{ $kandidat->id }}">
                            <button type="button" class="btn-coblos" onclick="konfirmasiCoblos({{ $kandidat->id }}, {{ $kandidat->nomor_urut }}, '{{ $kandidat->nama_ketua }} & {{ $kandidat->nama_wakil }}')">
                                COBLOS PASLON {{ $kandidat->nomor_urut }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 bg-white rounded-4 shadow-sm">
                    <h4 class="text-muted fw-bold">Belum ada data Paslon yang di-input oleh Admin.</h4>
                    <p class="text-secondary mb-0">Silakan masuk ke menu admin untuk menambah data paslon.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Script Pop-up Aksen Biru Toska -->
    <script>
        function konfirmasiCoblos(id, nomor, nama) {
            Swal.fire({
                title: 'Konfirmasi Pilihan',
                html: `Apakah Anda yakin ingin memilih <b>Paslon ${nomor}</b>?<br><span style="color: #15C5D2; font-weight: bold;">(${nama})</span><br><br><small style="color: #666;">Pilihan Anda tidak dapat diubah setelah dikirim!</small>`,
                icon: 'question',
                iconColor: '#15C5D2',
                showCancelButton: true,
                confirmButtonColor: '#15C5D2',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Coblos Sekarang!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-4 shadow-lg',
                    confirmButton: 'fw-bold px-4 py-2',
                    cancelButton: 'fw-bold px-4 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses Suara...',
                        text: 'Mohon tunggu sebentar',
                        iconColor: '#15C5D2',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    document.getElementById('form-vote-' + id).submit();
                }
            });
        }
    </script>

</body>

</html>