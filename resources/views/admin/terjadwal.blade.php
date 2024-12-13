<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa Terjadwal</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .hero {
            text-align: center;
            background: linear-gradient(135deg, #007bff, #007bff);
            color: white;
            padding: 50px 20px;
            border-radius: 12px 12px 0 0;
        }

        h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #eef6ff;
        }

        .success {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        select {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            font-weight: bold;
            text-align: center;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            padding: 15px;
            background: #f8f9fa;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            font-size: 0.9rem;
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

        <!-- Menampilkan data siswa yang akan mengikuti tes EPT -->
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

        <a href="{{ route('jadwal.index') }}" class="back-link">&laquo; Kembali ke dashboard</a>
    </div>

    <footer>
        &copy; {{ date('Y') }} UPT Bahasa UPN Veteran Jawa Timur.
    </footer>
</body>

</html>
