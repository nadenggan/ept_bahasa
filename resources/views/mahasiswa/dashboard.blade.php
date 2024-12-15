<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPT Pusat Bahasa - UPN Veteran Jawa Timur</title>
    <!-- Tambahkan link ke file CSS atau framework frontend seperti Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">UPT Pusat Bahasa</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#program">Program</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.logout') }}">Logout</a></li>
                <li class="nav-item"><a class="nav-link" href="/mahasiswa/profil">Profil</a></li>
            </ul>
        </div>
    </div>
</nav>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Menampilkan Pesan Error -->
    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Hero Section -->
    <div class="text-center my-5">
        <img src="{{ asset('/everyday-english.png') }}" alt="Everyday English" class="img-fluid">
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
             <a href="{{ route('mahasiswa.ept') }}"  class="btn btn-primary">Register EPT Test</a>
        </div>
        <div class="col-md-6 text-center">
            <img src="{{ asset('/ept-logo.png') }}" alt="EPT Logo" class="img-fluid">
        </div>
    </div>
</div>

<!-- Programs -->
<section id="program" class="py-5">
    <div class="container text-center">
        <h2 class="mb-4">We Provide Best Services</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="program-icon">📄</div>
                <h5>SAP</h5>
                <p>Structured document that outlines objectives and materials for a specific course.</p>
            </div>
            <div class="col-md-3">
                <div class="program-icon">📋</div>
                <h5>English Test (EPT)</h5>
                <p>Assessment designed to evaluate an individual's proficiency in the English language.</p>
            </div>
            <div class="col-md-3">
                <div class="program-icon">📚</div>
                <h5>Language Course</h5>
                <p>Designed to assist students in developing strong foreign language skills for academics.</p>
            </div>
            <div class="col-md-3">
                <div class="program-icon">🔄</div>
                <h5>Translator</h5>
                <p>Teaches skills required to convert written content from one language to another.</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section id="faq" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">FAQ (Frequently Asked Questions)</h2>
        <div class="accordion" id="faqAccordion">
            @foreach (['Foto berformat apa yang boleh dimasukkan?', 'Apakah durasi video yang dikirim boleh lebih dari 5 menit?', 'Berapa lama rentang waktu verifikasi?', 'Apakah data bisa diedit setelah dilakukan submit/kirim?', 'Bagaimana cara penulisan harga di form?'] as $index => $question)
                <div class="accordion-item faq-item">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}">
                            {{ $question }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}">
                        <div class="accordion-body">
                            Placeholder jawaban untuk pertanyaan ini.
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- About Us -->
<section id="about" class="py-5">
    <div class="container text-center">
        <h2>About Us</h2>
        <p>
            It is no longer something special to master foreign languages in this information era, 
            but it's a need, especially for highly educated communities. 
            The UPT Pusat Bahasa assists in improving English proficiency through various programs.
        </p>
        <a href="{{ route('mahasiswa.daftarKelasForm') }}" class="btn btn-primary">Register Course</a>
    </div>
</section>

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


    {{-- <form action="{{ route('mahasiswa.daftarKelasForm') }}" method="GET" style="display: inline;">
        <button type="submit">Daftar Kelas</button>
    </form>
    <form action="{{ route('mahasiswa.logout') }}" method="GET" style="display: inline;">
        <button type="submit">Logout</button>
    </form> --}}

    <!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
