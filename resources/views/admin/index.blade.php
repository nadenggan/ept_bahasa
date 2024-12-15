<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
        }

        .hero h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        .hero p {
            margin: 10px 0 0;
            font-size: 1.2rem;
        }

        .centered-text {
            text-align: center;
            font-size: 2rem;
            color: #4a90e2;
            margin-top: 30px;
            font-weight: bold;
        }

        .success {
            color: #4caf50;
            background: #e8f5e9;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }

        .error {
            color: #f44336;
            background: #ffebee;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
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
            margin-bottom: 20px;
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
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            font-weight: 500;
        }

        table tbody tr:hover {
            background: #f9f9f9;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .button-group form {
            flex: 1;
        }

        .button-group button {
            width: 100%;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9rem;
            color: #777;
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
    <div class="container">
        <div class="hero">
            <h1>Selamat Datang</h1>
            <p>Kelola jadwal EPT Test dan English Class dengan mudah dan efisien</p>
        </div>

        <h3 class="centered-text">Jadwal EPT Test</h3>

        @if (session('success'))
        <p class="success">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
        <p class="error">{{ $errors->first() }}</p>
        @endif

        <form action="{{ route('jadwal.store') }}" method="POST">
            @csrf
            <div>
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" required>
            </div>
            <div class="actions">
                <button type="submit">Tambah Jadwal</button>
            </div>
        </form>

        @forelse ($jadwals as $tanggal => $ruangan)
        <h4>{{ $tanggal }}</h4>
        <table>
            <thead>
                <tr>
                    <th>Ruangan</th>
                    <th>Kapasitas</th>
                    <th>Kuota Tersisa</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ruangan as $jadwal)
                <tr>
                    <td>{{ $jadwal->ruangan }}</td>
                    <td>{{ $jadwal->kapasitas }}</td>
                    <td>{{ $jadwal->kuota }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('jadwal.destroy', $tanggal) }}" method="POST" onsubmit="return confirm('Hapus semua jadwal untuk tanggal ini?');">
            @csrf
            @method('DELETE')
            <div class="actions">
                <button type="submit">Hapus Jadwal Tanggal {{ $tanggal }}</button>
            </div>
        </form>
        @empty
        <p>Belum ada jadwal.</p>
        @endforelse

        <div class="button-group">
            <form action="{{ route('admin.pendaftaran_tes') }}" method="GET">
                <button type="submit">Verifikasi Pendaftar EPT Test</button>
            </form>
            <form action="{{ route('admin.pendaftaran.terjadwal') }}" method="GET">
                <button type="submit">Data Pendaftar EPT Test</button>
            </form>
            <form action="{{ route('admin.jadwalkelas') }}" method="GET">
                <button type="submit">Jadwal English Class</button>
            </form>
            <form action="{{ route('admin.pendaftaran_kelas') }}" method="GET">
                <button type="submit">Data Pendaftar English Class</button>
            </form>
        </div>

        <div class="button-group">

            <form action="{{ route('logout') }}" method="GET">
                <button type="submit">Logout</button>
            </form>
        </div>

        <div class="footer">
            <p>&copy; 2024 UPT Bahasa UPN Veteran Jawa Timur</p>
        </div>
    </div>
</body>

</html>
