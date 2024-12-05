<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Tes Mahasiswa</title>
</head>

<body>
    <h1>Pendaftaran Tes Mahasiswa</h1>

    <h2>Daftar Mahasiswa yang Memilih Tanggal Tes</h2>
    <ul>
        @foreach ($pendaftaranTes as $pendaftaran)
        @if ($pendaftaran->status_daftar == 'dalam konfirmasi')
            <li>
                {{ $pendaftaran->mahasiswa->name }} - {{ $pendaftaran->jadwalTes->tanggal }}
                <!-- Form untuk memilih ruangan -->
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
            </li>
            @endif
        @endforeach
    </ul>
</body>

</html>