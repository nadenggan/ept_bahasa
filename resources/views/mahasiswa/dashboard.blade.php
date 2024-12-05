<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
</head>

<body>
    <h1>Selamat Datang di Dashboard Mahasiswa</h1>
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
    <h2>Jadwal Tes</h2>
    <ul>
        @forelse ($jadwalTes as $jadwal)
            <li>
                {{ $jadwal->tanggal }}
                <form action="{{ route('mahasiswa.pilih_tanggal') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tanggal" value="{{ $jadwal->tanggal }}">
                    <button type="submit">Pilih Tanggal</button>
                </form>
            </li>
        @empty
            <li>Tidak ada jadwal tes tersedia</li>
        @endforelse
    </ul>

    <h2>Status Pendaftaran</h2>
    <ul>
    @forelse ($pendaftaranTes as $pendaftaran)
        <li>
            Status: {{ $pendaftaran->status_daftar }}
            @if ($pendaftaran->status_daftar == 'dalam konfirmasi')
            @elseif ($pendaftaran->status_daftar == 'diterima')
                Tanggal: {{ $pendaftaran->jadwalTes->tanggal }}, Ruangan: {{ $pendaftaran->ruangan }}
            @endif
        </li>
    @empty
        <li>Anda belum memilih tanggal tes.</li>
    @endforelse
</ul>

<form action="{{ route('mahasiswa.logout') }}" method="GET" style="display: inline;">
        <button type="submit">Logout</button>
    </form>
</body>

</html>