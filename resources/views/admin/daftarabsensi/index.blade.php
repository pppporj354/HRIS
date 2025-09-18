@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-3 mb-3">
            <div class="card-header">Daftar Absensi Karyawan</div>
            <div class="card-body d-flex justify-content-end">
                <!-- Dropdown button untuk device kecil dibwaah 768 pixel atau size medium pada bootstrap 5 -->
                <div class="d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Aksi
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#" data-bs-target="#tanggalExcelModal"
                                data-bs-toggle="modal"><i class="bi bi-download me-1"></i><span>Excel</span></a></li>
                        <li><a class="dropdown-item" href="#" data-bs-target="#tanggalPDFModal"
                                data-bs-toggle="modal"><i class="bi bi-download me-1"></i><span>PDF</span></a></li>
                        <li><a class="dropdown-item" href="#" data-bs-target="#tanggalGenerateAbsensiModal"
                                data-bs-toggle="modal"><i class="bi bi-window me-1"></i><span>Absensi</span></a>
                        </li>
                    </ul>
                </div>

                <!-- List inline untuk device dengan ukuran medium ke atas -->
                <ul class="list-inline mb-0 d-none d-md-flex">
                    <li class="list-inline-item">
                        <button type="button" class="btn btn-outline-success" data-bs-target="#tanggalExcelModal"
                            data-bs-toggle="modal">
                            <i class="bi bi-download me-1"></i><span>Excel</span>
                        </button>
                    </li>
                    <li class="list-inline-item">
                        <button type="button" class="btn btn-outline-danger" data-bs-target="#tanggalPDFModal"
                            data-bs-toggle="modal">
                            <i class="bi bi-download me-1"></i><span>PDF</span>
                        </button>
                    </li>
                    <li class="list-inline-item">
                        <button type="button" class="btn btn-primary" data-bs-target="#tanggalGenerateAbsensiModal"
                            data-bs-toggle="modal">
                            <i class="bi bi-window me-1"></i><span>Absensi</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                    id="dataDaftarAbsensiTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Nama Karyawan</th>
                            <th>Status Absensi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>

    <!-- Start Modal Tanggal Generate Absensi -->
    <div class="modal fade" id="tanggalGenerateAbsensiModal" tabindex="-1"
        aria-labelledby="tanggalGenerateAbsensilModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tanggalGenerateAbsensiModalLabel">Pilih Tanggal Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('daftarabsensi.generateAbsenceData') }}" method="POST" id="generateAbsensiForm">
                    @csrf
                    <div class="modal-body">
                        <input type="date" class="form-control @error('tanggalGenerate') is-invalid @enderror"
                            id="tanggalGenerate" name="tanggalGenerate">
                        @error('tanggalGenerate')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                        <p class="fst-italic mb-0 mt-2">Notes : Pilih tanggal untuk generate data absensi (tidak perlu
                            memilih jika ingin menuju halaman absensi)
                        </p>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('daftarabsensi.absensi') }}" class="btn btn-dark" id="absensiButton">
                            <i class="bi bi-box-arrow-up-right"></i>
                            Ke Halaman Absensi
                        </a>
                        <button type="button" class="btn btn-primary" id="generateAbsensiButton"><i
                                class="bi bi-arrow-repeat"></i>
                            Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Tanggal Generate Absensi -->

    <!-- Start Modal Tanggal Export PDF -->
    <div class="modal fade" id="tanggalPDFModal" tabindex="-1" aria-labelledby="tanggalPDFModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tanggalPDFModalLabel">Pilih Tanggal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('daftarabsensi.exportPDF') }}" method="POST" id="exportPDFForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tanggalMulaiPDF">Mulai</label>
                            <input type="date" class="form-control @error('tanggalMulaiPDF') is-invalid @enderror"
                                id="tanggalMulaiPDF" name="tanggalMulaiPDF" value="{{ old('tanggalMulaiPDF') }}">
                            @error('tanggalMulaiPDF')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggalSampaiPDF">Sampai</label>
                            <input type="date" class="form-control @error('tanggalSampaiPDF') is-invalid @enderror"
                                id="tanggalSampaiPDF" name="tanggalSampaiPDF" value="{{ old('tanggalSampaiPDF') }}">
                            @error('tanggalSampaiPDF')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" id="exportPDFButton">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Tanggal Export PDF -->

    <!-- Start Modal Tanggal Export Excel -->
    <div class="modal fade" id="tanggalExcelModal" tabindex="-1" aria-labelledby="tanggalExcelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tanggalExcelModalLabel">Pilih Tanggal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('daftarabsensi.exportExcel') }}" method="POST" id="exportExcelForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tanggalMulaiExcel">Mulai</label>
                            <input type="date" class="form-control @error('tanggalMulaiExcel') is-invalid @enderror"
                                id="tanggalMulaiExcel" name="tanggalMulaiExcel">
                            @error('tanggalMulaiExcel')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggalSampaiExcel">Sampai</label>
                            <input type="date" class="form-control @error('tanggalSampaiExcel') is-invalid @enderror"
                                id="tanggalSampaiExcel" name="tanggalSampaiExcel">
                            @error('tanggalSampaiExcel')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="exportExcelButton">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Tanggal Export Excel -->

    <!-- Start Modal Edit Absensi -->
    <div class="modal fade" id="editDaftarAbsensiModal" tabindex="-1" aria-labelledby="editDaftarAbsensiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editDaftarAbsensiModalLabel">Sunting Daftar Absensi</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('daftarabsensi.update', ':id') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        @error('jamMasukEdit')
                            <div class="alert alert-danger" role="alert">
                                Tidak bisa menyunting data absensi jika jam masuk tidak pada kondisi default (sudah terisi
                                jam absen), jika ada kesalahan
                                absensi harap menghapus data dan generate data ulang pada tanggal yang telah ditentukan jika
                                perlu!
                            </div>
                        @enderror
                        <div class="form-group">
                            <label for="tanggalEdit" class="form-label">Tanggal</label>
                            <input class="form-control" type="text" name="tanggalEdit" id="tanggalEdit" disabled>
                        </div>
                        <div class="form-group">
                            <label for="jamMasukEdit" class="form-label">Jam Masuk</label>
                            <input class="form-control " type="text" name="jamMasukEdit" id="jamMasukEdit" readonly>
                        </div>
                        <div class="form-group">
                            <label for="namaKaryawanEdit" class="form-label">Nama Karyawan</label>
                            <input class="form-control" type="text" name="namaKaryawanEdit" id="namaKaryawanEdit"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="keteranganEdit" class="form-label">Keterangan</label>
                            <input class="form-control @error('keteranganEdit') is-invalid @enderror" type="text"
                                name="keteranganEdit" id="keteranganEdit">
                            @error('keteranganEdit')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="statusAbsensiEdit" class="form-label">Status Absensi</label>
                            <select name="statusAbsensiEdit" id="statusAbsensiEdit">
                                <option value="Masuk">Masuk</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Alpha">Alpha</option>
                            </select>
                            @error('statusAbsensiEdit')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Edit Absensi -->

    <!-- Start Modal Show Absensi -->
    <div class="modal fade" id="showDaftarAbsensiModal" tabindex="-1" aria-labelledby="showDaftarAbsensiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="showDaftarAbsensiModalLabel">Detail Data Absensi</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggalShow" class="form-label">Tanggal</label>
                        <input class="form-control" type="text" name="tanggalShow" id="tanggalShow" disabled>
                    </div>
                    <div class="form-group">
                        <label for="jamMasukShow" class="form-label">Jam Masuk</label>
                        <input class="form-control" type="text" name="jamMasukShow" id="jamMasukShow" disabled>
                    </div>
                    <div class="form-group">
                        <label for="namaKaryawanShow" class="form-label">Nama Karyawan</label>
                        <input class="form-control" type="text" name="namaKaryawanShow" id="namaKaryawanShow"
                            disabled>
                    </div>
                    <div class="form-group">
                        <label for="keteranganShow" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" name="keteranganShow" id="keteranganShow" disabled>
                    </div>
                    <div class="form-group">
                        <label for="statusAbsensiShow" class="form-label">Status Absensi</label>
                        <input class="form-control" type="text" name="statusAbsensiShow" id="statusAbsensiShow"
                            disabled>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Show Absensi -->
    @endsection
    @push('scripts')
        <script type="module">
            $(document).ready(function() {
                var table = $("#dataDaftarAbsensiTable").DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: "/getDaftarAbsensi",
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
                            data: "tanggal",
                            name: "tanggal"
                        },
                        {
                            data: "jam_masuk",
                            name: "jam_masuk"
                        },
                        {
                            data: "nama_karyawan",
                            name: "data_karyawan.nama"
                        },
                        {
                            data: "status_absensi",
                            name: "status_absensi"
                        },
                        {
                            data: "actions",
                            name: "actions",
                            orderable: false,
                            searchable: false
                        },
                    ],
                    order: [
                        [0, "desc"]
                    ],
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"],
                    ],
                    pageLength: 50, // Menentukan default jumlah data yang ditampilkan
                    language: {
                        emptyTable: "Belum terdapat data absensi yang tercatat!"
                    }
                });

                // Membuka modal secara langsung jika ada error
                @if (!empty(Session::get('error_in_modal')) && Session::get('error_in_modal') == 1)
                    $('#tanggalGenerateAbsensiModal').modal('show');
                @elseif (!empty(Session::get('error_in_modal')) && Session::get('error_in_modal') == 2)
                    $('#tanggalPDFModal').modal('show');
                @elseif (!empty(Session::get('error_in_modal')) && Session::get('error_in_modal') == 3)
                    $('#tanggalExcelModal').modal('show');
                @elseif (!empty(Session::get('error_in_modal')) && Session::get('error_in_modal') == 4)
                    // Konversi data absensi ke format JSON yang bisa digunakan di JavaScript
                    var absensiData = @json($absensi);
                    $('#editDaftarAbsensiModal').modal('show');

                    // Fungsi untuk menampilkan satu data absensi di HTML
                    function displayAbsensi(data) {
                        // Mempopulasikan data / mengisi data dari query data ajax pada datatable
                        $('#editDaftarAbsensiModal input[name="idEdit"]').val(data.id_absensi);
                        $('#editDaftarAbsensiModal input[name="tanggalEdit"]').val(data.tanggal);
                        $('#editDaftarAbsensiModal input[name="jamMasukEdit"]').val(data.jam_masuk);
                        $('#editDaftarAbsensiModal input[name="namaKaryawanEdit"]').val(data.data_karyawan.nama);
                        $('#editDaftarAbsensiModal input[name="keteranganEdit"]').val(data.keterangan);
                        $('#editDaftarAbsensiModal select[name="statusAbsensiEdit"]').val(data.status_absensi);

                        var updateRoute = "{{ route('daftarabsensi.update', ':id') }}";
                        updateRoute.replace(':id', data.id_absensi);

                        // Set form action URL dynamically
                        var actionUrl = '/daftarabsensi/' + data.id_absensi;
                        $('#editDaftarAbsensiModal form').attr('action', actionUrl);
                    }

                    // Fungsi untuk mencari satu data absensi berdasarkan id
                    function findAbsensiById(id) {
                        return absensiData.find(function(item) {
                            return item.id_absensi == id;
                        });
                    }

                    // Contoh penggunaan untuk menampilkan absensi dengan id tertentu
                    var absensiId =
                        @json(session('error_id_absensi')); // Ambil error_id_absensi dari flash session data dari kontroller
                    var absensiItem = findAbsensiById(absensiId);
                    displayAbsensi(absensiItem);
                @endif

                // Menangani event ketika modal ditutup
                $('#editDaftarAbsensiModal, #createDaftarAbsensiModal').on('hidden.bs.modal', function() {
                    $(this).find('.text-danger').remove();
                    $(this).find('.alert-danger').remove();
                    $(this).find('.form-control').removeClass('is-invalid');
                });

                // Edit form with bootstrap modal with data
                $('#dataDaftarAbsensiTable').on('click', '.btn-edit', function(event) {
                    event.preventDefault();
                    var $tr = $(this).closest('tr');
                    if ($tr.hasClass('child')) {
                        $tr = $tr.prev('.parent');
                    }

                    // mengambil data dari table row terdekat dari button edit yang dipilih
                    var data = table.row($tr).data();

                    // Mempopulasikan data / mengisi data dari query data ajax pada datatable
                    $('#editDaftarAbsensiModal input[name="idEdit"]').val(data.id_absensi);
                    $('#editDaftarAbsensiModal input[name="tanggalEdit"]').val(data.tanggal);
                    $('#editDaftarAbsensiModal input[name="jamMasukEdit"]').val(data.jam_masuk);
                    $('#editDaftarAbsensiModal input[name="namaKaryawanEdit"]').val(data.data_karyawan.nama);
                    $('#editDaftarAbsensiModal input[name="keteranganEdit"]').val(data.keterangan);
                    $('#editDaftarAbsensiModal select[name="statusAbsensiEdit"]').val(data.status_absensi);

                    var updateRoute = "{{ route('daftarabsensi.update', ':id') }}";
                    updateRoute.replace(':id', data.id_absensi);

                    // Set form action URL dynamically
                    var actionUrl = '/daftarabsensi/' + data.id_absensi;
                    $('#editDaftarAbsensiModal form').attr('action', actionUrl);

                });

                // show form with bootstrap modal
                $('#dataDaftarAbsensiTable').on('click', '.btn-show', function(event) {
                    event.preventDefault();
                    var $tr = $(this).closest('tr');
                    if ($tr.hasClass('child')) {
                        $tr = $tr.prev('.parent');
                    }

                    // mengambil data dari table row terdekat dari button show yang dipilih
                    var data = table.row($tr).data();

                    // Mempopulasikan data / mengisi data dari query data ajax pada datatable
                    $('#showDaftarAbsensiModal input[name="idShow"]').val(data.id_absensi);
                    $('#showDaftarAbsensiModal input[name="tanggalShow"]').val(data.tanggal);
                    $('#showDaftarAbsensiModal input[name="jamMasukShow"]').val(data.jam_masuk);
                    $('#showDaftarAbsensiModal input[name="namaKaryawanShow"]').val(data.data_karyawan.nama);
                    $('#showDaftarAbsensiModal input[name="keteranganShow"]').val(data.keterangan);
                    $('#showDaftarAbsensiModal input[name="statusAbsensiShow"]').val(data.status_absensi);
                });

                // Menangani klik tombol Generate pada modal
                $('#generateAbsensiButton').click(function() {
                    var tanggal = $('#tanggal').val(); // Dapatkan tanggal yang dipilih
                    if (tanggal === "") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Silakan pilih tanggal terlebih dahulu.'
                        });
                        return;
                    }

                    $('#generateAbsensiForm').submit(); // Submit form
                    $('#tanggalModal').modal('hide'); // Sembunyikan modal
                });

                // konfirmasi ke halaman absensi
                $('#absensiButton').click(function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin akses halaman absensi?',
                        text: "Anda akan logout dari sistem dan akan berpindah ke halaman absensi.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, lanjutkan!',
                        cancelButtonText: "Tidak, kembali!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = $(this).attr('href');
                        }
                    });
                });

                // delete confirmation with sweetalert by realrashid
                $(".datatable").on("click", ".btn-delete", function(e) {
                    e.preventDefault();
                    var form = $(this).closest("form");
                    var nama = $(this).data("nama");

                    Swal.fire({
                        title: "Apakah anda yakin ingin menghapus data absensi?",
                        text: "Anda tidak bisa mengembalikan data setelah terhapus!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "bg-primary",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Tidak, jangan hapus!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
