<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa Terjadwal</title>
</head>

<body>
    <h1>Data Mahasiswa Terjadwal</h1>

    <!-- Menampilkan pesan sukses -->
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Menampilkan data siswa yang akan mengikuti tes EPT -->
    @if ($terjadwal->isEmpty())
        <p>Tidak ada data mahasiswa terjadwal.</p>
    @else
        <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
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
                                    <option value="Belum Tes" {{ $pendaftaran->status_tes == 'Belum Tes' ? 'selected' : '' }}>
                                        Belum Tes</option>
                                    <option value="Sudah Tes" {{ $pendaftaran->status_tes == 'Sudah Tes' ? 'selected' : '' }}>
                                        Sudah Tes</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="{{ asset('storage/' . $pendaftaran->bukti_bayar) }}" target="_blank">View</a> <br>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Kembali ke dashboard admin -->
    <a href="{{ route('jadwal.index') }}">Kembali ke dashboard</a>
</body>

</html>