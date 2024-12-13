<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Tes EPT</title>
</head>

<body>
    <h1>Pilih jadwal tes EPT Anda!</h1>

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
        @if ($pendaftaranTes)
            <!-- Jika status daftar adalah belum bayar -->
            @if ($pendaftaranTes->status_daftar === 'belum bayar')
                <h3>Bayar Rp.110,000 ke no rekening: 1231241429</h3>
                <form action="{{ route('mahasiswa.konfirmasi_bayar', $pendaftaranTes->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <label for="bukti_bayar">Upload Bukti Pembayaran:</label>
                    <input type="file" name="bukti_bayar" accept=".jpg,.jpeg,.png,.pdf" required>
                    <button type="submit">Upload Bukti</button>
                </form>
                <!-- Jika status daftar adalah Dalam Konfirmasi -->
            @elseif ($pendaftaranTes->status_daftar === 'Dalam Konfirmasi')
                Status: Menunggu Konfirmasi Admin

                <!-- Jika status daftar adalah diterima -->
            @elseif ($pendaftaranTes->status_daftar === 'diterima')
                Tanggal: {{ $pendaftaranTes->jadwalTes->tanggal }} <br>
                {{ $pendaftaranTes->ruangan }}

                <!-- Jika status daftar adalah ditolak-->
            @elseif ($pendaftaranTes->status_daftar === 'Ditolak')
                Pendaftaran ditolak. Silakan hubungi admin untuk informasi lebih lanjut eptbahasa@gmail.com

            @endif
            </>
        @endif
    </ul>


    <form action="{{ route('mahasiswa.dashboard') }}" method="GET" style="display: inline;">
        <button type="submit">Kembali ke Dashboard</button>
    </form>
</body>

</html>