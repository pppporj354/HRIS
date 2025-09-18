<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Riwayat Gaji Karyawan</title>
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
    <h1>Riwayat Gaji Karyawan</h1>
    <h4>Riwayat gaji untuk bulan {{ $bln_mulai_text }} @if ($bln_mulai_text !== $bln_sampai_text)
            sampai bulan {{ $bln_sampai_text }}
        @endif
    </h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Bulan</th>
                <th>Nama Karyawan</th>
                <th>Gaji Pokok</th>
                <th>Potongan Ketidakhadiran</th>
                <th>Potongan Lain - Lain</th>
                <th>Total Potongan</th>
                <th>Total Tunjangan</th>
                <th>Total Gaji</th>
                <th>Keterangan</th>
                <th>Status Gaji</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gaji as $index => $gaji)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $gaji->tahun_bulan }}</td>
                    <td>{{ $gaji->dataKaryawan->nama }}</td>
                    <td>{{ $gaji->gaji_pokok }}</td>
                    <td>{{ $gaji->potongan_ketidakhadiran }}</td>
                    <td>{{ $gaji->potongan_lain }}</td>
                    <td>{{ $gaji->total_potongan }}</td>
                    <td>{{ $gaji->total_tunjangan }}</td>
                    <td>{{ $gaji->total_gaji }}</td>
                    <td>{{ $gaji->keterangan }}</td>
                    <td>{{ $gaji->status_gaji }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
