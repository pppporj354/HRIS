<table>
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
