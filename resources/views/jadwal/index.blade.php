<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Tes</title>
</head>
<body>

    <h3>Jadwal Tes</h3>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <form action="{{ route('jadwal.store') }}" method="POST" style="margin-bottom: 20px;">
        @csrf
        <div>
            <label for="tanggal">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" required>
        </div>
        <button type="submit">Tambah Jadwal</button>
    </form>

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
        <form action="{{ route('jadwal.destroy', $tanggal) }}" method="POST" onsubmit="return confirm('Hapus semua jadwal untuk tanggal ini?');">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus Jadwal Tanggal {{ $tanggal }}</button>
        </form>
    @empty
        <p>Belum ada jadwal.</p>
    @endforelse
</body>
</html>
