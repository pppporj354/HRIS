<table>
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
