<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration English Course</title>
    <!-- Tambahkan link ke file CSS atau framework frontend seperti Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color: #012970;">
        <div class="container">
            <!-- Logo -->
            <img src="{{ asset('/logo_upn.png') }}" alt="Everyday English" class="img-fluid" style="height: 40px; margin-right: 10px;">

            <!-- Navbar Brand -->
            <div class="d-flex flex-column align-items-center">
                <a class="navbar-brand" href="{{ route('mahasiswa.dashboard') }}">UPT Pusat Bahasa</a>
                <a class="navbar-brand" href="{{ route('mahasiswa.dashboard') }}" style="font-size: 0.8rem;">UPN "Veteran" Jawa Timur</a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.dashboard') }}">Program</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.dashboard') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.dashboard') }}">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- English Class Section -->
    <main class="container my-4">
        <section class="mb-5">
            <h2 class="text-center mb-4">Registration English Class</h2>
            <div class="row">
                <div class="col-md-12">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('mahasiswa.daftarKelas') }}" method="POST" class="bg-light p-4 border rounded">
                        @csrf
                        <div class="mb-3">
                            <label for="jadwal_kelas_id" class="form-label">Pilih Kelas:</label>
                            <select name="jadwal_kelas_id" id="jadwal_kelas_id" class="form-select" required>
                                @foreach ($kelas as $kls)
                                <option value="{{ $kls->id }}">
                                    {{ \Carbon\Carbon::parse($kls->tanggal)->format('Y-m-d') }}
                                    (Ruangan: {{ $kls->ruangan }}, Sisa Kuota: {{ $kls->kuota }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </form>
                </div>

            </div>
        </section>
    </main>

    <!-- English Proficiency Test Section -->
    <div style="background-color: #F1F3FC; height: 450px;">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <!-- Kolom untuk teks -->
                <div class="col-md-6">
                    <h1 style="pb-3">English Proficiency Test</h1>
                    <p>
                        EPT (English Proficiency Test) is a test used to test proficiency in English, especially for academic purposes.
                        The English language skills tested include listening, reading and writing.
                        The language components tested include vocabulary, structure, pronunciation, including intonation and emphasis.
                    </p>
                    <a href="{{ route('mahasiswa.ept') }}" class="btn" style="background-color: #012970; color: white;">Register EPT Test</a>
                </div>
                <!-- Kolom untuk gambar -->
                <div class="col-md-6 d-flex justify-content-center">
                    <img src="{{ asset('/ept-logo.png') }}" alt="EPT Logo" style="border-radius: 10px; height: 400px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-4">
                    <h5>Hubungi Kami</h5>
                    <p>Telepon: (031)8706362, (031)8796241</p>
                </div>
                <div class="col-md-4">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
