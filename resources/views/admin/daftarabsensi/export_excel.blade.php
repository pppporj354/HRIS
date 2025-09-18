<table>
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