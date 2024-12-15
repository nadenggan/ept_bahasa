<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pendaftaran Kelas Mahasiswa</title>
</head>
<body>
    <h1>Kelola Pendaftaran Kelas Mahasiswa</h1>

    <!-- Menampilkan pesan sukses -->
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Menampilkan pesan error -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Daftar Mahasiswa yang Mendaftar -->
    <h2>Daftar Mahasiswa yang Mendaftar</h2>
    <ul>
    @foreach ($pendaftaranKelas as $pendaftaran)
        <li>
            {{ $pendaftaran->mahasiswa->name }} - <strong>{{ $pendaftaran->kelas->ruangan }}</strong>
            <br>
            Tanggal Pendaftaran: {{ $pendaftaran->kelas->tanggal }}
            <br>
        </li>
    @endforeach

    </ul>

    <!-- Kembali ke dashboard admin -->
    <a href="{{ route('jadwal.index') }}">Kembali ke dashboard</a>
</body>
</html>
