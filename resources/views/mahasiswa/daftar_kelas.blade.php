<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Kelas Mahasiswa</title>
</head>
<body>
    <h1>Pendaftaran Kelas Mahasiswa</h1>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form untuk Pendaftaran Kelas -->
    <h2>Tambah Pendaftaran Kelas</h2>
    <form action="{{ route('mahasiswa.daftarKelas') }}" method="POST">
        @csrf
        <label for="jadwal_kelas_id">Pilih Kelas:</label>
        <select name="jadwal_kelas_id" id="jadwal_kelas_id" required>
            @foreach ($kelas as $kls)
                <option value="{{ $kls->id }}">
                    {{ $kls->nama_kelas }} (Ruangan: {{ $kls->ruangan }}, Sisa Kuota: {{ $kls->kuota }})
                </option>
            @endforeach
        </select>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>