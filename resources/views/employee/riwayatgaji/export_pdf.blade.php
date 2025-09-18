<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Slip Gaji Bulan {{ $tahun_bulan_parse }}</title>
    @vite('resources/js/jquery.js')
    @vite('resources/js/app.js')
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/css/dashboard.css'])
    <style>
        html {
            font-size: 12px;
        }

        .no-print {
            display: none;
        }

        .slip-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .slip-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .slip-logo {
            max-height: 100px;
        }

        .slip-title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
        }

        .slip-company {
            font-size: 18px;
            color: #333;
            /* Warna teks */
        }

        .slip-month {
            font-size: 16px;
            margin-top: 5px;
        }

        .slip-info {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
            border-top: 1px solid #ddd;
            padding-bottom: 10px;
            padding-top: 10px;
        }

        .slip-info p {
            margin: 5px 5px;
        }

        .slip-signature {
            text-align: right;
            margin-top: 50px;
        }

        .signature-line {
            display: inline-block;
            border-top: 2px solid #000;
            padding-top: 5px;
            margin-top: 50px;
        }

        .table-container {
            margin-top: 15px;
        }

        .table-container table {
            width: 100%;
            margin-bottom: 15px;
        }

        .table-container table th,
        .table-container table td {
            padding: 10px;
            text-align: center;
        }

        .table-container table th {
            background-color: #f0f0f0;
            font-weight: bold;
            border: 1px solid #ddd;
        }

        .table-container table td {
            border: 1px solid #ddd;
        }

        @media print {
            @page {
                size: portrait;
            }
        }
    </style>
</head>
<body>
    <div class="slip-container">
        <div class="slip-header">
            <img src="{{ Vite::asset('resources/assets/igi_logo.png') }}" alt="Company Logo" class="slip-logo">
            <div class="slip-title">Slip Gaji Karyawan</div>
            <div class="slip-company">PT. Indo Global Impex</div>
            <div class="slip-month">Bulan : {{ $tahun_bulan_parse }}</div>
        </div>

        <!-- Informasi Karyawan -->
        <div class="slip-info">
            <p><strong>Nama :</strong> {{ $gaji->dataKaryawan->nama }}</p>
            <p><strong>Jabatan :</strong> {{ $gaji->dataKaryawan->jabatan }}</p>
            <p><strong>Status :</strong> {{ $gaji->dataKaryawan->status_karyawan }}</p>
        </div>

        <!-- Pendapatan -->
        <div class="table-container">
            <h4>Pendapatan Kotor</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Gaji Pokok</td>
                        <td class="gaji-pokok">Rp. {{ $gaji->gaji_pokok }}</td>
                    </tr>
                    <tr>
                        <td>Total Tunjangan</td>
                        <td class="total-tunjangan">Rp. {{ $gaji->total_tunjangan }}</td>
                    </tr>
                    <tr>
                        <td>Total Pendapatan Kotor</td>
                        <td class="fw-bold total-pendapatan-kotor">Rp. {{ $gaji->gaji_pokok + $gaji->total_tunjangan }}
                        </td>
                    </tr>
                    <!-- Tambahkan penambahan gaji lainnya sesuai kebutuhan -->
                </tbody>
            </table>
        </div>

        <!-- Potongan Gaji -->
        <div class="table-container">
            <h4>Potongan</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Potongan Ketidakhadiran</td>
                        <td class="potongan-ketidakhadiran">Rp. {{ $gaji->potongan_ketidakhadiran }}</td>
                    </tr>
                    <tr>
                        <td>Potongan Lain</td>
                        <td class="potongan-lain">Rp. {{ $gaji->potongan_lain }}</td>
                    </tr>
                    <tr>
                        <td>Total Potongan</td>
                        <td class="fw-bold total-potongan">Rp. {{ $gaji->total_potongan }}</td>
                    </tr>
                    <!-- Tambahkan potongan gaji lainnya sesuai kebutuhan -->
                </tbody>
            </table>
        </div>

        <!-- Total Gaji -->
        <div class="table-container">
            <h4>Pendapatan Bersih</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total</td>
                        <td class="fw-bold total-gaji">Rp. {{ $gaji->total_gaji }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tanda Tangan -->
        <div class="slip-signature">
            <p>PT. Indo Global Impex</p>
            <div class="signature-line">Tanda Tangan</div>
        </div>

        <script type="module">
            $(document).ready(function() {
                function formatNumberWithDots(number) {
                    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }

                // Mengubah teks di dalam elemen sesuai format yang diinginkan
                $('.gaji-pokok').text(function() {
                    return 'Rp. ' + formatNumberWithDots(parseInt($(this).text().slice(4)));
                });

                $('.total-tunjangan').text(function() {
                    return 'Rp. ' + formatNumberWithDots(parseInt($(this).text().slice(4)));
                });

                $('.total-pendapatan-kotor').text(function() {
                    return 'Rp. ' + formatNumberWithDots(parseInt($(this).text().slice(4)));
                });

                $('.potongan-ketidakhadiran').text(function() {
                    return 'Rp. ' + formatNumberWithDots(parseInt($(this).text().slice(4)));
                });

                $('.potongan-lain').text(function() {
                    return 'Rp. ' + formatNumberWithDots(parseInt($(this).text().slice(4)));
                });

                $('.total-potongan').text(function() {
                    return 'Rp. ' + formatNumberWithDots(parseInt($(this).text().slice(4)));
                });

                $('.total-gaji').text(function() {
                    return 'Rp. ' + formatNumberWithDots(parseInt($(this).text().slice(4)));
                });

                // Memicu pencetakan saat halaman dimuat
                window.onload = function() {
                    window.print();
                };
            });
        </script>
    </div>
</body>

</html>
