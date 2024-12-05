<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Tes Mahasiswa</title>
</head>

<body>
    <h1>Pendaftaran Tes Mahasiswa</h1>
    
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

    <!-- Antrian Siswa yang Daftar Tes-->
    <h2>Daftar Mahasiswa yang Memilih Tanggal Tes</h2>
    <ul>
        @foreach ($pendaftaranTes as $pendaftaran)
            <!-- Verifikasi Pembayaran -->
            @if ($pendaftaran->status_daftar == 'Dalam Konfirmasi')
                <li>
                    {{ $pendaftaran->mahasiswa->name }} - {{ $pendaftaran->jadwalTes->tanggal }}
                    Bukti Pembayaran:
                    <a href="{{ asset('storage/' . $pendaftaran->bukti_bayar) }}" target="_blank">Lihat Bukti</a> <br>

                    <form action="{{ route('admin.verifikasi_bayar', $pendaftaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit">Verifikasi Pembayaran</button>
                    </form>
            @endif

                <!-- Form untuk memilih ruangan -->
                @if ($pendaftaran->status_daftar == 'Diterima')
                    {{ $pendaftaran->mahasiswa->name }} - {{ $pendaftaran->jadwalTes->tanggal }}
                    <form action="{{ route('admin.tentukan_ruangan', $pendaftaran->id) }}" method="POST">
                        @csrf
                        <select name="ruangan">
                            <option value="Ruangan 1">Ruangan 1</option>
                            <option value="Ruangan 2">Ruangan 2</option>
                            <option value="Ruangan 3">Ruangan 3</option>
                            <option value="Ruangan 4">Ruangan 4</option>
                        </select>
                        <button type="submit">Tentukan Ruangan</button>
                    </form>
                @endif
        @endforeach
    </ul>

    <!-- Kembali ke dashboard admin -->
    <a href="{{ route('jadwal.index') }}">Kembali ke dashboard</a>
</body>

</html>