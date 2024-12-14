<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <div class="container">
        <div class="hero">
            <h1>Selamat Datang</h1>
            <p>Kelola jadwal tes dan kelas dengan mudah dan efisien</p>
        </div>

        <h3>Jadwal Kelas</h3>

        <!-- Menampilkan pesan sukses -->
        @if (session('success'))
        <p class="success">{{ session('success') }}</p>
        @endif
        <!-- Menampilkan pesan error -->
        @if ($errors->any())
        <p class="error">{{ $errors->first() }}</p>
        @endif

        <!-- Form untuk menambahkan jadwal kelas -->
        <form action="{{ route('kelas.store') }}" method="POST">
            @csrf
            <div>
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" required>
            </div>
            <div>
                <label for="ruangan">Ruangan:</label>
                <input type="text" id="ruangan" name="ruangan" required>
            </div>
            <div>
                <label for="kuota">Kuota:</label>
                <input type="number" id="kuota" name="kuota" value="30" required>
            </div>
            <div class="actions">
                <button type="submit">Tambah Jadwal</button>
            </div>
        </form>

        <!-- Menampilkan jadwal kelas yang sudah ada -->
        @forelse ($kelass as $tanggal => $ruangans)
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
                @foreach ($ruangans as $kelas)
                <tr>
                    <td>{{ $kelas->ruangan }}</td>
                    <td>{{ $kelas->kuota }}</td>
                    <td>{{ $kelas->kuota }}</td> <!-- Bisa ditambah logika untuk menghitung kuota tersisa -->
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Menghapus jadwal kelas -->
        <form action="{{ route('admin.jadwalkelas.destroy', $kelas->id) }}" method="POST"
            onsubmit="return confirm('Hapus jadwal untuk kelas ini?');">
            @csrf
            @method('DELETE')
            <div class="actions">
                <button type="submit">Hapus Jadwal Kelas {{ $kelas->tanggal }}</button>
            </div>
        </form>
        @empty
        <p>Belum ada jadwal.</p>
        @endforelse



        <!-- Tombol navigasi tambahan -->
        <div class="button-group">
            <form action="{{ route('admin.jadwalkelas') }}" method="GET">
                <button type="submit">English Class Schedule</button>
            </form>
            <form action="{{ route('admin.pendaftaran_tes') }}" method="GET">
                <button type="submit">Pendaftaran Tes</button>
            </form>
            <form action="{{ route('admin.pendaftaran.terjadwal') }}" method="GET">
                <button type="submit">Data Siswa Tes</button>
            </form>
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
