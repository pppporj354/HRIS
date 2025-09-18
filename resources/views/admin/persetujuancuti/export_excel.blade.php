<table>
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
