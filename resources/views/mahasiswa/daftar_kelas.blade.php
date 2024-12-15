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
    <header class="bg-primary text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h5">UPT Pusat Bahasa - UPN Veteran Jawa Timur</h1>
            <nav>
                <a href="{{ route('mahasiswa.dashboard') }}" class="text-white me-3">Home</a> 
                <a href="#" class="text-white">Profile</a>
            </nav>
        </div>
    </header>

    <main class="container my-4">
        <section class="mb-5">
            <h2 class="text-center mb-4">Registration English Course</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="bg-light p-3 border rounded">
                        <h5>Rules Registration</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="bi bi-pencil"></i> Send Formulir</li>
                            <li class="mb-2"><i class="bi bi-person-check"></i> Verification by Admin</li>
                            <li><i class="bi bi-check-circle"></i> Enrolled</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
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

        

        <div class="container my-5" style="background: rgba(0, 22, 88, 0.08);" >
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>English Proficiency Test</h2><br><br>
                    <p>
                        EPT (English Proficiency Test) is a test used to test proficiency in English, especially for academic purposes. 
                        The English language skills tested include listening, reading and writing. 
                        The language components tested include vocabulary, structure, pronunciation, including intonation and emphasis.
                    </p>
                     <a href="{{ route('mahasiswa.dashboard') }}"  class="btn btn-primary">Dashboard</a>
                </div>
                <div class="col-md-6 text-center p-3">
                    <img src="{{ asset('/ept-logo.png') }}" alt="EPT Logo" class="img-fluid">
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white py-3">
        <div class="container">
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
