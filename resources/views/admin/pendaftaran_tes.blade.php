<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Tes Mahasiswa</title>
    <link rel="stylesheet" href="../css/daftar.css">
</head>

<body>
    <div class="hero">
        <h1>Pendaftaran Tes Mahasiswa</h1>
        <p>Pastikan semua informasi sudah lengkap dan benar sebelum mendaftar.</p>
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

        <!-- Antrian Siswa yang Daftar Tes -->
        <h2>Daftar Mahasiswa yang Memilih Tanggal Tes</h2>
        <ul>
            @foreach ($pendaftaranTes as $pendaftaran)
                <li>
                    @if ($pendaftaran->status_daftar == 'Dalam Konfirmasi')
                        <strong>Nama:</strong> {{ $pendaftaran->mahasiswa->name }}<br>
                        <strong>Tanggal Tes:</strong> {{ $pendaftaran->jadwalTes->tanggal }}
                        <strong>Bukti Pembayaran:</strong> <a href="{{ asset('storage/' . $pendaftaran->bukti_bayar) }}"
                            target="_blank">Lihat Bukti</a>

                            <!-- Verifikasi Bayar -->
                        <form action="{{ route('admin.verifikasi_bayar', $pendaftaran->id) }}" method="POST"
                            class="form-group ">
                            @csrf
                            @method('PUT')
                            <button type="submit">Verifikasi Pembayaran</button>
                        </form>

                        <!-- Batal Verifikasi -->
                        <form action="{{ route('admin.batal_verifikasi', $pendaftaran->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger">Batal</button>
                        </form>
                    @endif

                    @if ($pendaftaran->status_daftar == 'Diterima')
                        <strong>Nama:</strong> {{ $pendaftaran->mahasiswa->name }}<br>
                        <strong>Tanggal Tes:</strong> {{ $pendaftaran->jadwalTes->tanggal }}
                        <form action="{{ route('admin.tentukan_ruangan', $pendaftaran->id) }}" method="POST" class="form-group">
                            @csrf
                            <label for="ruangan">Pilih Ruangan:</label>
                            <select name="ruangan" id="ruangan">
                                <option value="Ruangan 1">Ruangan 1</option>
                                <option value="Ruangan 2">Ruangan 2</option>
                                <option value="Ruangan 3">Ruangan 3</option>
                                <option value="Ruangan 4">Ruangan 4</option>
                            </select>
                            <button type="submit">Tentukan Ruangan</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>

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