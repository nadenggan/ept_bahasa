<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Tes</title>
</head>

<body>
    <div class="container">
        <div class="hero">
            <h1>Selamat Datang</h1>
            <p>Kelola jadwal tes dan kelas dengan mudah dan efisien</p>
        </div>
        <button type="submit">Tambah Jadwal</button>
    </form>

        <h3>Jadwal Tes</h3>

        <!-- Menampilkan pesan sukses -->
        @if (session('success'))
        <p class="success">{{ session('success') }}</p>
        @endif
        <!-- Menampilkan pesan error -->
        @if ($errors->any())
        <p class="error">{{ $errors->first() }}</p>
        @endif

        <!-- Form untuk menambahkan jadwal tes EPT -->
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

        <!-- Menampilkan jadwal tes EPT -->
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

        <!-- Menghapus jadwal tes EPT -->
        <form action="{{ route('jadwal.destroy', $tanggal) }}" method="POST"
            onsubmit="return confirm('Hapus semua jadwal untuk tanggal ini?');">
            @csrf
            @method('DELETE')
            <div class="actions">
                <button type="submit">Hapus Jadwal Tanggal {{ $tanggal }}</button>
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
            <form action="{{ route('admin.pendaftaran_kelas') }}" method="GET">
                <button type="submit">Data Siswa English Class</button>
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

    <!-- Route halaman data mahasiswa yang akan mengikuti tes EPT -->
    <form action="{{ route('admin.pendaftaran.terjadwal') }}" method="GET" style="display: inline;">
        <button type="submit">Data Siswa Tes</button>
    </form>

    <!-- Route logout -->
    <form action="{{ route('logout') }}" method="GET" style="display: inline;">
        <button type="submit">Logout</button>
    </form>
</body>

</html>