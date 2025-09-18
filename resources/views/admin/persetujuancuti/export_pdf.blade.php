<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Permohonan Cuti</title>
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
    <h1>Daftar Permohonan Cuti</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Pemohon</th>
                <th>Mulai Cuti</th>
                <th>Selesai Cuti</th>
                <th>Keterangan</th>
                <th>Status Cuti</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datapersetujuancuti as $index => $datapersetujuancuti)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $datapersetujuancuti->dataKaryawan->nama }}</td>
                    <td>{{ $datapersetujuancuti->mulai_cuti }}</td>
                    <td>{{ $datapersetujuancuti->selesai_cuti }}</td>
                    <td>{{ $datapersetujuancuti->keterangan }}</td>
                    <td>{{ $datapersetujuancuti->status_cuti }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
