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
    <h1>Daftar Kandidat</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Nomor Telepon</th>
                <th>Status Rekrutmen</th>
                <th>Keahlian</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datarekrutmen as $index => $datarekrutmen)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $datarekrutmen->nama }}</td>
                    <td>{{ $datarekrutmen->alamat }}</td>
                    <td>{{ $datarekrutmen->nomor_telepon }}</td>
                    <td>{{ $datarekrutmen->status_rekrutmen }}</td>
                    <td>{{ $datarekrutmen->keahlian }}</td>
                    <td>{{ $datarekrutmen->catatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
