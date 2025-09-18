<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Absensi Karyawan</title>
    <style>
        html {
            font-size: 12px;
        }

        .table {
            border-collapse: collapse !important;
            width: 100%;
        }

        .table-bordered th,
        .table-bordered td {
            padding: 0.5rem;
            border: 1px solid black !important;
        }
    </style>
</head>

<body>
    <h1>Daftar Absensi</h1>
    <h4>Mulai dari tanggal {{ $tgl_mulai_text }} sampai tanggal {{ $tgl_sampai_text }}</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Nama Karyawan</th>
                <th>Keterangan</th>
                <th>Status Absensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absensi as $index => $absensi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $absensi->tanggal }}</td>
                    <td>{{ $absensi->jam_masuk }}</td>
                    <td>{{ $absensi->dataKaryawan->nama }}</td>
                    <td>{{ $absensi->keterangan }}</td>
                    <td>{{ $absensi->status_absensi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
