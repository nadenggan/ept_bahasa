<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa Terjadwal</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 5px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #4a90e2;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
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
    </style>
</head>

<body>
    <div class="hero">
        <h1>Data Mahasiswa Terjadwal</h1>
        <p>Berikut adalah daftar mahasiswa yang sudah terjadwal mengikuti tes.</p>
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
        @if ($terjadwal->isEmpty())
            <p>Tidak ada data mahasiswa terjadwal.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Tanggal Tes</th>
                        <th>Ruangan</th>
                        <th>Status Tes</th>
                        <th>Bukti Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($terjadwal as $pendaftaran)
                        <tr>
                            <td>{{ $pendaftaran->mahasiswa->name }}</td>
                            <td>{{ $pendaftaran->mahasiswa->jurusan }}</td>
                            <td>{{ $pendaftaran->jadwalTes->tanggal }}</td>
                            <td>{{ $pendaftaran->ruangan }}</td>
                            <td>
                                <!-- Update status tes oleh admin -->
                                <form action="{{ route('admin.update_status_tes', $pendaftaran->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status_tes" onchange="this.form.submit()">
                                        <option value="Belum Tes" {{ $pendaftaran->status_tes == 'Belum Tes' ? 'selected' : '' }}>Belum Tes</option>
                                        <option value="Sudah Tes" {{ $pendaftaran->status_tes == 'Sudah Tes' ? 'selected' : '' }}>Sudah Tes</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="{{ asset('storage/' . $pendaftaran->bukti_bayar) }}" target="_blank">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="cta">
            <!-- Kembali ke dashboard admin -->
            <a href="{{ route('jadwal.index') }}" class="back-link">&laquo; Kembali ke dashboard</a>
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} UPT Bahasa UPN Veteran Jawa Timur.
    </footer>

</body>

</html>
