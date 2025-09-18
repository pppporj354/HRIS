@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-3 mb-3">
            <div class="card-header">Data Karyawan</div>
            <div class="card-body d-flex justify-content-end">
                <!-- Dropdown button untuk device kecil dibwaah 768 pixel atau size medium pada bootstrap 5 -->
                <div class="d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Aksi
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="{{ route('datakaryawan.exportExcel') }}" id="linkExportExcel"><i
                                    class="bi bi-download me-1"></i><span>Excel</span></a></li>
                        <li><a class="dropdown-item" href="{{ route('datakaryawan.exportPDF') }}" id="linkExportPDF"><i
                                    class="bi bi-download me-1"></i><span>PDF</span></a></li>
                        <li><a class="dropdown-item" href="#" data-bs-target="#createDataKaryawan"
                                data-bs-toggle="modal"> <i class="bi bi-plus-circle"></i><span>Tambah</span></a>
                        </li>
                    </ul>
                </div>

                <!-- List inline untuk device dengan ukuran medium ke atas -->
                <ul class="list-inline mb-0 d-none d-md-flex">
                    <li class="list-inline-item">
                        <a href="{{ route('datakaryawan.exportExcel') }}" id="linkExportExcel"
                            class="btn btn-outline-success">
                            <i class="bi bi-download me-1"></i><span>Excel</span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ route('datakaryawan.exportPDF') }}" id="linkExportPDF" class="btn btn-outline-danger">
                            <i class="bi bi-download me-1"></i><span>PDF</span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <button type="button" class="btn btn-primary" data-bs-target="#createDataKaryawan"
                            data-bs-toggle="modal">
                            <i class="bi bi-plus-circle me-1"></i><span>Tambah</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                    id="dataKaryawanTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Status Karyawan</th>
                            <th>Keahlian</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>

    {{-- start modal section --}}

    {{-- start modal create --}}
    <div class="modal fade" id="createDataKaryawan" tabindex="-1" aria-labelledby="createDataKaryawanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('datakaryawan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createDataKaryawanModalLabel">Tambah Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4 class="text-center">Data Karyawan</h4>
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama</label>
                            <input class="form-control @error('nama') is-invalid @enderror" type="text" name="nama"
                                id="namaCreate" value="{{ old('nama') }}" placeholder="Masukkan nama karyawan">
                            @error('nama')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input class="form-control @error('alamat') is-invalid @enderror" type="text" name="alamat"
                                id="alamatCreate" value="{{ old('alamat') }}" placeholder="Masukkan alamat karyawan">
                            @error('alamat')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                            <input class="form-control @error('nomorTelepon') is-invalid @enderror" type="tel"
                                name="nomorTelepon" id="nomorTeleponCreate" value="{{ old('nomorTelepon') }}"
                                placeholder="Masukkan nomor telepon karyawan">
                            @error('nomorTelepon')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="statusKaryawan" class="form-label">Status Karyawan</label>
                            <select class="d-block" name="statusKaryawan" id="statusKaryawanCreate">
                                <option value="Karyawan Tetap">Karyawan Tetap</option>
                                <option value="Karyawan Kontrak">Karyawan Kontrak</option>
                            </select>
                            @error('statusKaryawan')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="keahlian" class="form-label">Keahlian</label>
                            <input class="form-control @error('keahlian') is-invalid @enderror" type="text"
                                name="keahlian" id="keahlianCreate" value="{{ old('keahlian') }}"
                                placeholder="Masukkan keahlian yang dimiliki karyawan">
                            @error('keahlian')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input class="form-control @error('jabatan') is-invalid @enderror" type="text"
                                name="jabatan" id="jabatanCreate" value="{{ old('jabatan') }}"
                                placeholder="Masukkan jabatan">
                            @error('jabatan')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <h4 class="text-center mt-3">Data Akun</h4>
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input class="form-control @error('username') is-invalid @enderror" type="text"
                                name="username" id="usernameCreate" value="{{ old('username') }}"
                                placeholder="Masukkan username">
                            @error('username')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text"
                                name="email" id="emailCreate" value="{{ old('email') }}"
                                placeholder="Masukkan email">
                            @error('email')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="password" class="form-label">Password baru</label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                name="password" id="passwordCreate" value="" placeholder="Masukkan password"
                                autocomplete>
                            @error('password')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="password_confirmation" class="form-label">Konfirmasi password baru</label>
                            <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                type="password" name="password_confirmation" id="password_confirmationCreate"
                                value="" placeholder="Masukkan password ulang" autocomplete>
                            @error('password_confirmation')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="role" class="form-label">Role</label>
                            <select class="d-block" name="role" id="roleCreate">
                                <option value="Administrator">Administrator</option>
                                <option value="Employee">Karyawan Reguler</option>
                            </select>
                            @error('role')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <p class="fw-bold">Note : Pastikan username karyawan yang dimasukkan merupakan username yang unik
                            dan pastikan sudah benar karena tidak dapat diganti setelah data karyawan beserta akun telah
                            berhasil dibuat.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal create --}}

    {{-- start modal edit --}}
    <div class="modal fade" id="editDataKaryawan" tabindex="-1" aria-labelledby="editDataKaryawanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('datakaryawan.update', ':id') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h4 class="modal-title" id="editDataKaryawanModalLabel">Edit Data Karyawan</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-center">Data Utama</h5>
                        <div class="form-group">
                            <input class="form-control" type="hidden" name="idEdit" id="idEdit" value="">
                        </div>
                        <div class="form-group">
                            <label for="namaEdit" class="form-label">Nama</label>
                            <input class="form-control @error('namaEdit') is-invalid
@enderror" type="text"
                                name="namaEdit" id="namaEdit" value="{{ old('namaEdit') }}"
                                placeholder="Masukkan nama karyawan">
                            @error('namaEdit')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamatEdit" class="form-label">Alamat</label>
                            <input class="form-control @error('alamatEdit') is-invalid
@enderror" type="text"
                                name="alamatEdit" id="alamatEdit" value="{{ old('alamatEdit') }}"
                                placeholder="Masukkan alamat karyawan">
                            @error('alamatEdit')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nomorTeleponEdit" class="form-label">Nomor Telepon</label>
                            <input class="form-control @error('nomorTeleponEdit') is-invalid @enderror" type="tel"
                                name="nomorTeleponEdit" id="nomorTeleponEdit" value="{{ old('nomorTeleponEdit') }}"
                                placeholder="Masukkan nomor telepon karyawan">
                            @error('nomorTeleponEdit')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="statusKaryawanEdit" class="form-label">Status Karyawan</label>
                            <select class="d-block" name="statusKaryawanEdit" id="statusKaryawanEdit">
                                <option value="Karyawan Tetap">Karyawan Tetap</option>
                                <option value="Karyawan Kontrak">Karyawan Kontrak</option>
                            </select>
                            @error('statusKaryawanEdit')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keahlianEdit" class="form-label">Keahlian</label>
                            <input class="form-control @error('keahlianEdit') is-invalid @enderror" type="text"
                                name="keahlianEdit" id="keahlianEdit" value="{{ old('keahlianEdit') }}"
                                placeholder="Masukkan keahlian yang dimiliki karyawan">
                            @error('keahlianEdit')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jabatanEdit" class="form-label">Jabatan</label>
                            <input class="form-control @error('jabatanEdit') is-invalid @enderror" type="text"
                                name="jabatanEdit" id="jabatanEdit" value="{{ old('jabatanEdit') }}"
                                placeholder="Masukkan jabatan">
                            @error('jabatanEdit')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <h5 class="text-center mt-3">Data Akun</h5>
                        <div class="form-group">
                            <label for="usernameEdit" class="form-label">Username</label>
                            <input class="form-control @error('usernameEdit') is-invalid @enderror" type="text"
                                name="usernameEdit" id="usernameEdit" value="{{ old('usernameEdit') }}" placeholder="Masukkan username"
                                disabled>
                            @error('usernameEdit')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="emailEdit" class="form-label">Email</label>
                            <input class="form-control @error('emailEdit') is-invalid @enderror" type="text"
                                name="emailEdit" id="emailEdit" value="{{ old('emailEdit') }}" placeholder="Masukkan email">
                            @error('emailEdit')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="passwordEdit" class="form-label">Password Baru</label>
                            <input class="form-control @error('passwordEdit') is-invalid @enderror" type="password"
                                name="passwordEdit" id="passwordEdit" value=""
                                placeholder="Masukkan password baru (bisa dikosongkan)" autocomplete>
                            @error('passwordEdit')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="passwordEdit_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input class="form-control @error('passwordEdit_confirmation') is-invalid @enderror"
                                type="password" name="passwordEdit_confirmation" id="passwordEdit_confirmation"
                                value="" placeholder="Masukkan ulang password baru" autocomplete>
                            @error('passwordEdit_confirmation')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="roleEdit" class="form-label">Role</label>
                            <select class="d-block" name="roleEdit" id="roleEdit">
                                <option value="Administrator">Administrator</option>
                                <option value="Employee">Karyawan</option>
                            </select>
                            @error('roleEdit')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal edit --}}

    {{-- start modal detail / show --}}
    <div class="modal fade" id="showDataKaryawan" tabindex="-1" aria-labelledby="showDataKaryawanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="showDataKaryawanModalLabel">Detail Data Karyawan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama</label>
                        <input class="form-control" type="text" name="nama" id="nama" disabled>
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input class="form-control" type="text" name="alamat" id="alamat" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                        <input class="form-control" type="tel" name="nomorTelepon" id="nomorTelepon" disabled>
                    </div>
                    <div class="form-group mt-3">
                        <label for="statusKaryawan" class="form-label">Status Karyawan</label>
                        <select name="statusKaryawan" id="statusKaryawan" disabled>
                            <option value="Karyawan Tetap">Karyawan Tetap</option>
                            <option value="Karyawan Kontrak">Karyawan Kontrak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keahlian" class="form-label">Keahlian</label>
                        <input class="form-control" type="text" name="keahlian" id="keahlian" disabled>
                    </div>
                    <div class="form-group">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input class="form-control" type="text" name="jabatan" id="jabatan" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal detail / show --}}

    {{-- end modal section --}}
@endsection
@push('scripts')
    <script type="module">
        $(document).ready(function() {
            // show table record with datatable
            var table = $("#dataKaryawanTable").DataTable({
                serverSide: true,
                processing: true,
                ajax: "/getDataKaryawan",
                columns: [{
                        data: "id_data_karyawan",
                        name: "id_data_karyawan",
                        visible: false
                    },
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama",
                        name: "nama"
                    },
                    {
                        data: "status_karyawan",
                        name: "status_karyawan"
                    },
                    {
                        data: "keahlian",
                        name: "keahlian",
                        orderable: false,
                    },
                    {
                        data: "jabatan",
                        name: "jabatan",
                        orderable: false,
                    },
                    {
                        data: "aksi",
                        name: "aksi",
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
                language: {
                    emptyTable: "Belum terdapat data karyawan yang tercatat!"
                }
            });

            // Membuka modal secara langsung jika ada error pada input di modal create dan edit
            @if (!empty(Session::get('error_in_modal')) && Session::get('error_in_modal') == 1)
                $('#createDataKaryawan').modal('show');
            @elseif (!empty(Session::get('error_in_modal')) && Session::get('error_in_modal') == 2)
                $('#editDataKaryawan').modal('show');
            @endif

            // Menangani event ketika modal ditutup
            $('#editDataKaryawan, #createDataKaryawan').on('hidden.bs.modal', function() {
                $(this).find('.text-danger').remove();
                $(this).find('.form-control').removeClass('is-invalid');
            });

            // Edit form with bootstrap modal with data
            $('#dataKaryawanTable').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                var $tr = $(this).closest('tr');
                if ($tr.hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();

                // Mempopulasikan data / mengisi data dari query data ajax pada datatable
                $('#editDataKaryawan input[name="idEdit"]').val(data.id_data_karyawan);
                $('#editDataKaryawan input[name="namaEdit"]').val(data.nama);
                $('#editDataKaryawan input[name="alamatEdit"]').val(data.alamat);
                $('#editDataKaryawan input[name="nomorTeleponEdit"]').val(data.nomor_telepon);
                $('#editDataKaryawan select[name="statusKaryawanEdit"]').val(data.status_karyawan);
                $('#editDataKaryawan input[name="keahlianEdit"]').val(data.keahlian);
                $('#editDataKaryawan input[name="jabatanEdit"]').val(data.jabatan);
                $('#editDataKaryawan input[name="usernameEdit"]').val(data.user.username);
                $('#editDataKaryawan input[name="emailEdit"]').val(data.user.email);
                $('#editDataKaryawan select[name="roleEdit"]').val(data.user.role);



                var updateRoute = "{{ route('datakaryawan.update', ':id') }}";
                updateRoute.replace(':id', data.id_data_karyawan);

                // Set form action URL dynamically
                var actionUrl = '/datakaryawan/' + data.id_data_karyawan;
                $('#editDataKaryawan form').attr('action', actionUrl);

            });

            // show form with bootstrap modal
            $('#dataKaryawanTable').on('click', '.btn-show', function(event) {
                event.preventDefault();
                var $tr = $(this).closest('tr');
                if ($tr.hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();

                // Populate your show modal with data
                $('#showDataKaryawan input[name="nama"]').val(data.nama);
                $('#showDataKaryawan input[name="alamat"]').val(data.alamat);
                $('#showDataKaryawan input[name="nomorTelepon"]').val(data.nomor_telepon);
                $('#showDataKaryawan select[name="statusKaryawan"]').val(data.status_karyawan);
                $('#showDataKaryawan input[name="keahlian"]').val(data.keahlian);
                $('#showDataKaryawan input[name="jabatan"]').val(data.jabatan);
            });

            // delete confirmation with sweetalert by realrashid
            $(".datatable").on("click", ".btn-delete", function(e) {
                e.preventDefault();
                var form = $(this).closest("form");
                var nama = $(this).data("nama");

                Swal.fire({
                    title: "Apakah anda yakin ingin menghapus data \n" + nama + "?",
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
