<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pendaftaran Kelas Mahasiswa</title>
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
            margin: auto;
            padding: 20px;
        }

        .hero {
            background: linear-gradient(135deg, #4a90e2, #50c9c3);
            color: #fff;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 40px;
        }

        .hero h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        .hero p {
            margin: 10px 0;
            font-size: 1.2rem;
        }

        h2 {
            color: #4a90e2;
            margin-top: 30px;
            font-size: 1.8rem;
        }

        h3 {
            margin-top: 30px;
            color: #4a90e2;
        }

        .success, .error {
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }

        .success {
            color: #4caf50;
            background: #e8f5e9;
        }

        .error {
            color: #f44336;
            background: #ffebee;
        }

        .actions {
            text-align: right;
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
        }

        button:hover {
            background: #357ab8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }

        table thead {
            background: #4a90e2;
            color: #fff;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            font-weight: 500;
        }

        table tbody tr:hover {
            background: #f9f9f9;
        }

        .cta {
            text-align: center;
            margin-top: 30px;
        }

        .cta a {
            color: #4a90e2;
            font-size: 1rem;
            text-decoration: none;
        }

        .cta a:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.9rem;
            color: #777;
            padding: 20px;
            background-color: #f4f6f9;
        }

        footer a {
            color: #4a90e2;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="hero">
        <h1>Data Pendaftar English Class</h1>
        <p>Kelola pendaftaran kelas mahasiswa dengan mudah.</p>
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

        <!-- Daftar Mahasiswa yang Mendaftar -->
        <h2>Daftar Mahasiswa yang Mendaftar</h2>

        @if ($pendaftaranKelas->isEmpty())
        <p>Tidak ada data pendaftar untuk kelas ini.</p>
        @else
        <table>
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Ruangan Kelas</th>
                    <th>Tanggal Pendaftaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendaftaranKelas as $pendaftaran)
                <tr>
                    <td>{{ $pendaftaran->mahasiswa->name }}</td>
                    <td>{{ $pendaftaran->kelas->ruangan }}</td>
                    <td>{{ $pendaftaran->kelas->tanggal }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Kembali ke dashboard admin -->
        <div class="cta">
            <a href="{{ route('jadwal.index') }}">&laquo; Kembali ke dashboard</a>
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} UPT Bahasa UPN Veteran Jawa Timur.
    </footer>

</body>

</html>
