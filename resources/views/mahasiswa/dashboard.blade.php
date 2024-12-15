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
    <nav class="navbar navbar-expand-lg" style="background-color: #012970;">
        <div class="container">
            <!-- Logo -->
            <img src="{{ asset('/logo_upn.png') }}" alt="Everyday English" class="img-fluid" style="height: 40px; margin-right: 10px;">

            <!-- Navbar Brand -->
            <div class="d-flex flex-column align-items-center">
                <a class="navbar-brand" href="#">UPT Pusat Bahasa</a>
                <a class="navbar-brand" href="#" style="font-size: 0.8rem;">UPN "Veteran" Jawa Timur</a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#program">Program</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.logout') }}">Logout</a></li>
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
    <div class="text-center">
        <img src="{{ asset('/everyday-english.png') }}" alt="Everyday English" class="img-fluid">
    </div>

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
                @foreach ([
                'Foto berformat apa yang boleh dimasukkan?' => 'Format .jpeg dan .png',
                'Apakah durasi video yang dikirim boleh lebih dari 5 menit?' => 'Tidak apa-apa',
                'Berapa lama rentang waktu verifikasi?' => 'Tidak melebihi jam 1 hari kerja kecuali mendaftar diluar jam kerja',
                'Apakah data bisa diedit setelah dilakukan submit/kirim?' => 'Data tidak bisa diedit, Silahkan datang langsung ke UPT Bahasa untuk melakukan konfirmasi data terbaru',
                'Bagaimana cara penulisan harga di form?' => 'Penulisan sesuai KBBI'
                ] as $question => $answer)
                <div class="accordion-item faq-item">
                    <h2 class="accordion-header" id="heading{{ $loop->index }}">
                        <button class="accordion-button {{ $loop->index !== 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}">
                            {{ $question }}
                        </button>
                    </h2>
                    <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->index === 0 ? 'show' : '' }}">
                        <div class="accordion-body">
                            {{ $answer }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Us -->
    <section id="about" class="py-5" style="background-image: url('{{ asset('/frame.png') }}'); background-size: cover; background-position: center;">
        <div class="container text-center" style="background-color: rgba(241, 243, 252, 0.8); padding: 20px;">
            <h2>About Us</h2>
            <p>
                It is no longer something special to master foreign languages in this information era,
                but it's a need, especially for highly educated communities.
                The UPT Pusat Bahasa assists in improving English proficiency through various programs.
            </p>
            <a href="{{ route('mahasiswa.daftarKelasForm') }}" class="btn" style="background-color: #012970; color: white;">Register Course</a>
        </div>
    </section>

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
