<table>
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
