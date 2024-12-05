<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
</head>

<body>
    <h1>Selamat Datang di Dashboard Mahasiswa</h1>

    <!-- Menampilkan Pesan Sukses -->
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Menampilkan Pesan Error -->
    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Menampilkan Jadwal tes EPT yang tersedia-->
    <h2>Jadwal Tes</h2>
    <ul>
        @forelse ($jadwalTes as $jadwal)
            <li>
                {{ $jadwal->tanggal }}
                <form action="{{ route('mahasiswa.pilih_tanggal') }}" method="POST">
                    @csrf
                    <!-- Pilih jadwal tes EPT -->
                    <input type="hidden" name="tanggal" value="{{ $jadwal->tanggal }}">
                    <button type="submit">Pilih Tanggal</button>
                </form>
            </li>
        @empty
            <li>Tidak ada jadwal tes tersedia</li>
        @endforelse
    </ul>



    <!-- Upload Bukti pembayaran oleh mahasiswa -->
    <ul>
        @foreach ($pendaftaranTes as $pendaftaran)
            <!-- Jika status daftar adalah belum bayar -->
            @if ($pendaftaran->status_daftar === 'belum bayar')
                <h3>Bayar Rp.110,000 ke no rekening: 1231241429</h3>
                <form action="{{ route('mahasiswa.konfirmasi_bayar', $pendaftaran->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <label for="bukti_bayar">Upload Bukti Pembayaran:</label>
                    <input type="file" name="bukti_bayar" accept=".jpg,.jpeg,.png,.pdf" required>
                    <button type="submit">Upload Bukti</button>
                </form>
                <!-- Jika status daftar adalah Dalam Konfirmasi -->
            @elseif ($pendaftaran->status_daftar === 'Dalam Konfirmasi')
                Status: Menunggu Konfirmasi Admin

                <!-- Jika status daftar adalah diterima -->
            @elseif ($pendaftaran->status_daftar === 'diterima')
                Tanggal: {{ $pendaftaran->jadwalTes->tanggal }} <br>
                {{ $pendaftaran->ruangan }}
            @endif
            </>
        @endforeach
    </ul>


    <form action="{{ route('mahasiswa.logout') }}" method="GET" style="display: inline;">
        <button type="submit">Logout</button>
    </form>
</body>

</html>