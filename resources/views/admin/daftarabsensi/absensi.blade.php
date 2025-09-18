<!DOCTYPE html>
<html class="w-100 h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('igi_logo.png') }}" type="image/x-icon">
    <title>Absensi</title>
    @vite('resources/js/jquery.js')
    @vite('resources/js/app.js')
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/css/dashboard.css'])
</head>

<body class="w-100 h-100 d-flex justify-content-center align-items-center">
    <div class="card text-center col-md-5">
        <div class="card-header">
            <span>Absensi</span>
        </div>
        <div class="card-body ">
            <div class="alert alert-primary fst-italic" role="alert">
                Note : Masukkan email dan password untuk absensi hari ini! Cek absensi anda pada dashboard,
                jika ada kendala silahkan hubungi admin.
            </div>
            <form method="POST" action="{{ route('daftarabsensi.catatAbsensi') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="fw-bold mb-2">Email atau Username:</label>
                    <input class="form-control @error('login') is-invalid @enderror" type="text" name="login"
                        id="login" required>
                </div>
                @error('login')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="password" class="fw-bold mb-2 mt-3">Password:</label>
                    <input class="form-control" type="password" name="password" id="password" required>
                </div>
                @error('password')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
                <button class="btn btn-primary col-md-8 mt-4" type="submit">Catat Kehadiran</button>
            </form>
            <hr class="w-50 border-3 rounded mx-auto" />
            <form action="{{ route('daftarabsensi.logoutAbsensi') }}" method="POST">
                @csrf
                <button class="btn btn-secondary col-md-8" type="submit">Keluar</button>
            </form>
        </div>
    </div>

    {{-- separator --}}
    {{-- <div class="col-md-1"></div> --}}

    <div class="card text-center col-md-6 ms-3">
        <div class="card-header">
            <span>Daftar Absensi Hari Ini Tanggal {{ $tanggalsaatini }}</span>
        </div>
        <div class="card-body ">
            <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                id="dataDaftarAbsensiHariIniTable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>No</th>
                        <th>Jam Masuk</th>
                        <th>Nama Karyawan</th>
                        <th>Status Absensi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @include('sweetalert::alert')

    <script type="module">
        $(document).ready(function() {
            var table = $("#dataDaftarAbsensiHariIniTable").DataTable({
                serverSide: true,
                processing: true,
                ajax: "/getAbsensiHariIni",
                columns: [{
                        data: "id_absensi",
                        name: "id_absensi",
                        visible: false
                    },
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "jam_masuk",
                        name: "jam_masuk"
                    },
                    {
                        data: "nama_karyawan",
                        name: "nama_karyawan"
                    },
                    {
                        data: "status_absensi",
                        name: "status_absensi"
                    }
                ],
                order: [
                    [0, "asc"]
                ],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"],
                ],
                pageLength: 10,
                language: {
                    emptyTable: "Belum terdapat data absensi yang tercatat!"
                }
            });

            // reload setiap sekitar 7 detik untuk datatables
            setInterval(function() {
                table.ajax.reload(null, false); // hanya reload data pada datatables
            }, 7500);

        });
    </script>
</body>

</html>
