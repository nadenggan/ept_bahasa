<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Tes Mahasiswa</title>
    <link rel="stylesheet" href="../css/daftar.css">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }

        .hero {
            background: linear-gradient(135deg, #4a90e2, #50c9c3);
            color: #fff;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
        }

        .hero h1 {
            margin: 0;
            font-size: 2.8rem;
        }

        .hero p {
            margin: 10px 0 0;
            font-size: 1.2rem;
        }

        h2 {
            color: #4a90e2;
            margin-top: 30px;
            font-size: 1.8rem;
        }

        .success {
            color: #4caf50;
            background: #e8f5e9;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            font-size: 1rem;
        }

        .error {
            color: #f44336;
            background: #ffebee;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            font-size: 1rem;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
        }

        input[type="date"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        button {
            background: #4a90e2;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background: #357ab8;
        }

        .cta {
            margin-top: 30px;
            text-align: center;
        }

        .back-link {
            color: #4a90e2;
            text-decoration: none;
            font-size: 1rem;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .pendaftaran-list {
            margin-top: 20px;
        }

        .pendaftaran-list li {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .pendaftaran-list li form {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
        }

        .pendaftaran-item {
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            /* Memberikan jarak antar tombol */
            margin-top: 10px;
        }

        .button-group form {
            margin: 0;
            display: flex;
        }

        .button-group button {
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        .button-group button:hover {
            opacity: 0.9;
        }

        .button-group button:nth-child(2) {
            background: #f44336;
            color: white;
        }

        .button-group button:nth-child(1) {
            background: #4caf50;
            color: white;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.9rem;
            color: #777;
        }

        footer {
            padding: 20px;
            background-color: #f4f6f9;
            color: #777;
            font-size: 0.9rem;
        }

        footer a {
            color: #4a90e2;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="hero">
        <h1>Pendaftaran Tes Mahasiswa</h1>
        <p>Pastikan semua informasi sudah lengkap dan benar sebelum mendaftar.</p>
    </div>

    <div class="container">
        <!-- Menampilkan pesan sukses -->
        @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Menampilkan pesan error -->
        @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Daftar Mahasiswa yang Memilih Tanggal Tes -->
        <h2>Daftar Mahasiswa yang Memilih Tanggal Tes</h2>
        <ul class="pendaftaran-list">
            @foreach ($pendaftaranTes as $pendaftaran)
            <li>
                @if ($pendaftaran->status_daftar == 'Dalam Konfirmasi')
                <div class="pendaftaran-item">
                    <strong>Nama:</strong> {{ $pendaftaran->mahasiswa->name }}<br>
                    <strong>Tanggal Tes:</strong> {{ $pendaftaran->jadwalTes->tanggal }}<br>
                    <strong>Bukti Pembayaran:</strong>
                    <a href="{{ asset('storage/' . $pendaftaran->bukti_bayar) }}" target="_blank">Lihat Bukti</a>

                    <div class="button-group">
                        <!-- Verifikasi Bayar -->
                        <form action="{{ route('admin.verifikasi_bayar', $pendaftaran->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit">Verifikasi Pembayaran</button>
                        </form>

                        <!-- Batal Verifikasi -->
                        <form action="{{ route('admin.batal_verifikasi', $pendaftaran->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" style="background: #f44336;">Batal</button>
                        </form>
                    </div>
                </div>

                @endif

                @if ($pendaftaran->status_daftar == 'Diterima')
                <strong>Nama:</strong> {{ $pendaftaran->mahasiswa->name }}<br>
                <strong>Tanggal Tes:</strong> {{ $pendaftaran->jadwalTes->tanggal }}
                <form action="{{ route('admin.tentukan_ruangan', $pendaftaran->id) }}" method="POST">
                    @csrf
                    <label for="ruangan">Pilih Ruangan:</label>
                    <select name="ruangan" id="ruangan">
                        <option value="Ruangan 1">Ruangan 1</option>
                        <option value="Ruangan 2">Ruangan 2</option>
                        <option value="Ruangan 3">Ruangan 3</option>
                        <option value="Ruangan 4">Ruangan 4</option>
                    </select>
                    <button type="submit">Tentukan Ruangan</button>
                </form>
                @endif
            </li>
            @endforeach
        </ul>

        <div class="cta">
            <a href="{{ route('jadwal.index') }}" class="back-link">&laquo; Kembali ke dashboard</a>
        </div>
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} UPT Bahasa UPN Veteran Jawa Timur.</p>
    </footer>
</body>

</html>
