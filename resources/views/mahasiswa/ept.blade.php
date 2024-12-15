<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Tes EPT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">UPT Pusat Bahasa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#program">Program</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Success and Error Alerts -->
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>

    <!-- English Proficiency Test Section -->
    <div class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>English Proficiency Test</h2>
                <p>
                    EPT (English Proficiency Test) is a test used to test proficiency in English, especially for academic purposes. 
                    The English language skills tested include listening, reading and writing. 
                    The language components tested include vocabulary, structure, pronunciation, including intonation and emphasis.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="{{ asset('/ept-logo.png') }}" alt="EPT Logo" class="img-fluid">
            </div>
        </div>
    </div>

    <!-- Schedule and Registration Form -->
    <div class="container my-5">
        <div class="row">
            <!-- Calendar Section -->
            <div class="col-md-6">
                <div class="calendar">
                    <h4 class="mb-3 text-center">Schedule</h4>
                    <ul class="list-group">
                        @forelse ($jadwalTes as $jadwal)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $jadwal->tanggal }}
                                <form action="{{ route('mahasiswa.pilih_tanggal') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tanggal" value="{{ $jadwal->tanggal }}">
                                    <button type="submit" class="btn btn-primary btn-sm">Pilih</button>
                                </form>
                            </li>
                        @empty
                            <li class="list-group-item text-center">Tidak ada jadwal tes tersedia</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Payment Form Section -->
            <div class="col-md-6">
                <div class="form-section">
                    @if ($pendaftaranTes)
                        @if ($pendaftaranTes->status_daftar === 'belum bayar')
                            <h4>Upload Bukti Pembayaran</h4>
                            <p>Bayar Rp.110,000 ke no rekening: 1231241429</p>
                            <form action="{{ route('mahasiswa.konfirmasi_bayar', $pendaftaranTes->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="bukti_bayar" class="form-label">Bukti Pembayaran</label>
                                    <input type="file" class="form-control" name="bukti_bayar" accept=".jpg,.jpeg,.png,.pdf" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Upload</button>
                            </form>
                        @elseif ($pendaftaranTes->status_daftar === 'Dalam Konfirmasi')
                            <div class="alert alert-info">Status: Menunggu Konfirmasi Admin</div>
                        @elseif ($pendaftaranTes->status_daftar === 'diterima')
                            <div class="alert alert-success">
                                <p>Tanggal: {{ $pendaftaranTes->jadwalTes->tanggal }}</p>
                                <p>Ruangan: {{ $pendaftaranTes->ruangan }}</p>
                            </div>
                        @elseif ($pendaftaranTes->status_daftar === 'Ditolak')
                            <div class="alert alert-danger text-center">
                                Pendaftaran ditolak. Hubungi admin: eptbahasa@gmail.com
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <form action="{{ route('mahasiswa.dashboard') }}" method="GET">
                <button type="submit" class="btn btn-secondary">Kembali ke Dashboard</button>
            </form>
        </div>
    </div>

<!-- Footer -->
<footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Hubungi Kami</h5>
                    <p>Telepon: (031)8706362, (031)8796241</p>
                </div>
                <div
                
                class="col-md-4">
                    <h5>Unit Pelaksana Teknis:</h5>
                    <ul class="list-unstyled">
                        <li>UPT - TIK</li>
                        <li>UPT - Perpustakaan</li>
                        <li>UPT - PKK</li>
                        <li>UPT - Laboratorium Terpadu</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Lembaga & Biro:</h5>
                    <ul class="list-unstyled">
                        <li>LP3M</li>
                        <li>Biro Umum & Keuangan</li>
                        <li>Biro Mahasiswa & Kerjasama</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
