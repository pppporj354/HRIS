<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee List</title>
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
    <h1>Daftar Karyawan</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Nomor Telepon</th>
                <th>Status Karyawan</th>
                <th>Keahlian</th>
                <th>Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datakaryawan as $index => $datakaryawan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $datakaryawan->nama }}</td>
                    <td>{{ $datakaryawan->alamat }}</td>
                    <td>{{ $datakaryawan->nomor_telepon }}</td>
                    <td>{{ $datakaryawan->status_karyawan }}</td>
                    <td>{{ $datakaryawan->keahlian }}</td>
                    <td>{{ $datakaryawan->jabatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
