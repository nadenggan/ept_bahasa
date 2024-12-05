<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Tes</title>
</head>

<body>

    <h3>Jadwal Tes</h3>

    <!-- Menampilkan pesan sukses -->
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    <!-- Menampilkan pesan error -->
    @if ($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <!-- Form untuk menambahkan jadwal tes EPT -->
    <form action="{{ route('jadwal.store') }}" method="POST" style="margin-bottom: 20px;">
        @csrf
        <div>
            <label for="tanggal">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" required>
        </div>
        <button type="submit">Tambah Jadwal</button>
    </form>

    <!-- Menampilkan jadwal tes EPT -->
    @forelse ($jadwals as $tanggal => $ruangan)
        <h4>{{ $tanggal }}</h4>
        <table border="1" style="margin-bottom: 20px;">
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
            <button type="submit">Hapus Jadwal Tanggal {{ $tanggal }}</button>
        </form>
    @empty
        <p>Belum ada jadwal.</p>
    @endforelse

    <!-- Route halaman antrian pendaftaran tes EPT -->
    <form action="{{ route('admin.pendaftaran_tes') }}" method="GET" style="display: inline;">
        <button type="submit">Pendaftaran Tes</button>
    </form>

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