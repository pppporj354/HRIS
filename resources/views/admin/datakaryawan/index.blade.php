@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="dashboard-header mb-4">
                    <h3 class="mb-0 fw-bold">Data Karyawan</h3>
                    <p class="text-muted mb-0">Kelola informasi karyawan perusahaan</p>
                </div>

                @component('components.datatable-card', [
                    'title' => 'Data Karyawan',
                    'id' => 'dataKaryawanTable',
                    'columns' => ['Id', 'No.', 'Nama', 'Status Karyawan', 'Keahlian', 'Jabatan', 'Aksi']
                ])
                    @slot('actions')
                        <!-- Dropdown button for small devices (< 768px) -->
                        <div class="d-block d-md-none">
                            <button class="btn btn-primary rounded-pill dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear-fill me-1"></i>Aksi
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="{{ route('datakaryawan.exportExcel') }}" id="linkExportExcel">
                                    <i class="bi bi-file-excel me-2 text-success"></i><span>Export Excel</span></a></li>
                                <li><a class="dropdown-item" href="{{ route('datakaryawan.exportPDF') }}" id="linkExportPDF">
                                    <i class="bi bi-file-pdf me-2 text-danger"></i><span>Export PDF</span></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" data-bs-target="#createDataKaryawan" data-bs-toggle="modal">
                                    <i class="bi bi-plus-circle me-2 text-primary"></i><span>Tambah Karyawan</span></a>
                                </li>
                            </ul>
                        </div>

                        <!-- Action buttons for medium devices and up -->
                        <div class="d-none d-md-flex gap-2">
                            <x-dt-button
                                href="{{ route('datakaryawan.exportExcel') }}"
                                id="linkExportExcel"
                                type="outline-success"
                                icon="file-excel"
                                label="Excel"
                                tooltip="Export ke Excel"
                            />

                            <x-dt-button
                                href="{{ route('datakaryawan.exportPDF') }}"
                                id="linkExportPDF"
                                type="outline-danger"
                                icon="file-pdf"
                                label="PDF"
                                tooltip="Export ke PDF"
                            />

                            <x-dt-button
                                modal="createDataKaryawan"
                                type="primary"
                                icon="plus-circle"
                                label="Tambah"
                                tooltip="Tambah karyawan baru"
                            />
                        </div>
                    @endslot
                @endcomponent
            </div>
        </div>
    </div>

    {{-- ================= MODAL SECTION ================= --}}

    {{-- start modal create --}}
    <div class="modal fade" id="createDataKaryawan" tabindex="-1" aria-labelledby="createDataKaryawanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('datakaryawan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold" id="createDataKaryawanModalLabel">Tambah Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        {{-- This section was previously closed with </x-form-section> which caused the error --}}
                        <div class="form-section mb-3">
                            <h6 class="text-primary fw-semibold mb-3">Data Karyawan</h6>
                            <div class="form-group mb-3">
                                <label for="namaCreate" class="form-label small fw-medium">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                    <input class="form-control border-start-0 @error('nama') is-invalid @enderror"
                                           type="text" name="nama" id="namaCreate"
                                           value="{{ old('nama') }}" placeholder="Masukkan nama lengkap">
                                </div>
                                @error('nama')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mt-1">
                                <label for="alamatCreate" class="form-label">Alamat</label>
                                <input class="form-control @error('alamat') is-invalid @enderror" type="text" name="alamat"
                                    id="alamatCreate" value="{{ old('alamat') }}" placeholder="Masukkan alamat karyawan">
                                @error('alamat')
                                    <div class="text-danger">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                            <x-form-input
                                label="Nomor Telepon"
                                name="nomorTelepon"
                                type="tel"
                                icon="telephone"
                                placeholder="Masukkan nomor telepon"
                                :errors="$errors"
                                required
                            />
                            <x-form-select
                                label="Status Karyawan"
                                name="statusKaryawan"
                                icon="briefcase"
                                :options="['Karyawan Tetap' => 'Karyawan Tetap', 'Karyawan Kontrak' => 'Karyawan Kontrak']"
                                placeholder="Pilih status karyawan"
                                :errors="$errors"
                                required
                            />
                            <x-form-input
                                label="Keahlian"
                                name="keahlian"
                                icon="tools"
                                placeholder="Masukkan keahlian yang dimiliki"
                                :errors="$errors"
                                required
                            />
                            <x-form-input
                                label="Jabatan"
                                name="jabatan"
                                icon="person-badge"
                                placeholder="Masukkan jabatan"
                                :errors="$errors"
                                required
                            />
                        </div>

                        <x-form-section title="Data Akun" icon="person-check" color="secondary">
                            <x-form-input
                                label="Username"
                                name="username"
                                icon="person"
                                placeholder="Masukkan username"
                                :errors="$errors"
                                required
                            />
                            <x-form-input
                                label="Email"
                                name="email"
                                type="email"
                                icon="envelope"
                                placeholder="Masukkan alamat email"
                                :errors="$errors"
                                required
                            />
                            <x-form-input
                                label="Password"
                                name="password"
                                type="password"
                                icon="lock"
                                placeholder="Masukkan password"
                                :errors="$errors"
                                required
                            />
                            <x-form-input
                                label="Konfirmasi Password"
                                name="password_confirmation"
                                type="password"
                                icon="lock-fill"
                                placeholder="Masukkan ulang password"
                                :errors="$errors"
                                required
                            />
                            <x-form-select
                                label="Role Pengguna"
                                name="role"
                                icon="shield-check"
                                :options="['Administrator' => 'Administrator', 'Employee' => 'Karyawan']"
                                placeholder="Pilih role pengguna"
                                :errors="$errors"
                                required
                            />
                        </x-form-section>

                        <div class="alert alert-info d-flex align-items-start mb-0">
                            <i class="bi bi-info-circle me-2 mt-1 flex-shrink-0"></i>
                            <small><strong>Catatan:</strong> Pastikan username karyawan yang dimasukkan merupakan username yang unik
                            dan pastikan sudah benar karena tidak dapat diganti setelah data karyawan beserta akun telah
                            berhasil dibuat.</small>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 ms-2">
                            <i class="bi bi-save me-1"></i>Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal create --}}

    {{-- start modal edit --}}
    <div class="modal fade" id="editDataKaryawan" tabindex="-1" aria-labelledby="editDataKaryawanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('datakaryawan.update', ':id') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title fw-bold" id="editDataKaryawanModalLabel">Edit Data Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control" type="hidden" name="idEdit" id="idEdit" value="">
                        <div class="form-group mb-2">
                            <label for="namaEdit" class="form-label">Nama</label>
                            <input class="form-control @error('namaEdit') is-invalid @enderror" type="text"
                                name="namaEdit" id="namaEdit" value="{{ old('namaEdit') }}"
                                placeholder="Masukkan nama karyawan">
                            @error('namaEdit')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="alamatEdit" class="form-label">Alamat</label>
                            <input class="form-control @error('alamatEdit') is-invalid @enderror" type="text"
                                name="alamatEdit" id="alamatEdit" value="{{ old('alamatEdit') }}"
                                placeholder="Masukkan alamat karyawan">
                            @error('alamatEdit')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="nomorTeleponEdit" class="form-label">Nomor Telepon</label>
                            <input class="form-control @error('nomorTeleponEdit') is-invalid @enderror" type="tel"
                                name="nomorTeleponEdit" id="nomorTeleponEdit" value="{{ old('nomorTeleponEdit') }}"
                                placeholder="Masukkan nomor telepon karyawan">
                            @error('nomorTeleponEdit')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="statusKaryawanEdit" class="form-label">Status Karyawan</label>
                            <select class="form-select" name="statusKaryawanEdit" id="statusKaryawanEdit">
                                <option value="Karyawan Tetap">Karyawan Tetap</option>
                                <option value="Karyawan Kontrak">Karyawan Kontrak</option>
                            </select>
                            @error('statusKaryawanEdit')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="keahlianEdit" class="form-label">Keahlian</label>
                            <input class="form-control @error('keahlianEdit') is-invalid @enderror" type="text"
                                name="keahlianEdit" id="keahlianEdit" value="{{ old('keahlianEdit') }}"
                                placeholder="Masukkan keahlian yang dimiliki karyawan">
                            @error('keahlianEdit')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="jabatanEdit" class="form-label">Jabatan</label>
                            <input class="form-control @error('jabatanEdit') is-invalid @enderror" type="text"
                                name="jabatanEdit" id="jabatanEdit" value="{{ old('jabatanEdit') }}"
                                placeholder="Masukkan jabatan">
                            @error('jabatanEdit')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>
                        <h6 class="text-secondary fw-semibold mb-3">Data Akun</h6>
                        <div class="form-group mb-2">
                            <label for="usernameEdit" class="form-label">Username</label>
                            <input class="form-control" type="text" name="usernameEdit" id="usernameEdit" value="{{ old('usernameEdit') }}" placeholder="Masukkan username" disabled>
                            <small class="text-muted">Username tidak dapat diubah.</small>
                        </div>
                        <div class="form-group mb-2">
                            <label for="emailEdit" class="form-label">Email</label>
                            <input class="form-control @error('emailEdit') is-invalid @enderror" type="text"
                                name="emailEdit" id="emailEdit" value="{{ old('emailEdit') }}" placeholder="Masukkan email">
                            @error('emailEdit')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="passwordEdit" class="form-label">Password Baru</label>
                            <input class="form-control @error('passwordEdit') is-invalid @enderror" type="password"
                                name="passwordEdit" id="passwordEdit"
                                placeholder="Kosongkan jika tidak ingin diubah" autocomplete>
                            @error('passwordEdit')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="passwordEdit_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input class="form-control" type="password" name="passwordEdit_confirmation" id="passwordEdit_confirmation"
                                placeholder="Masukkan ulang password baru" autocomplete>
                        </div>
                        <div class="form-group my-2">
                            <label for="roleEdit" class="form-label">Role</label>
                            <select class="form-select" name="roleEdit" id="roleEdit">
                                <option value="Administrator">Administrator</option>
                                <option value="Employee">Karyawan</option>
                            </select>
                            @error('roleEdit')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 ms-2">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal edit --}}

    {{-- start modal detail / show --}}
    <div class="modal fade" id="showDataKaryawan" tabindex="-1" aria-labelledby="showDataKaryawanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold" id="showDataKaryawanModalLabel">Detail Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted" style="width: 150px;">Nama</td>
                            <td class="fw-medium" id="namaShow"></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Alamat</td>
                            <td class="fw-medium" id="alamatShow"></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nomor Telepon</td>
                            <td class="fw-medium" id="nomorTeleponShow"></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td class="fw-medium" id="statusKaryawanShow"></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Keahlian</td>
                            <td class="fw-medium" id="keahlianShow"></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jabatan</td>
                            <td class="fw-medium" id="jabatanShow"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal detail / show --}}

@endsection

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            // Initialize tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

            // Enhanced DataTable initialization
            var table = $("#dataKaryawanTable").DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
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
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: "nama",
                        name: "nama"
                    },
                    {
                        data: "status_karyawan",
                        name: "status_karyawan",
                        className: 'text-center'
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
                        searchable: false,
                        className: 'text-center'
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

            // Show modal automatically if there are validation errors
            @if (!empty(Session::get('error_in_modal')) && Session::get('error_in_modal') == 1)
                $('#createDataKaryawan').modal('show');
            @elseif (!empty(Session::get('error_in_modal')) && Session::get('error_in_modal') == 2)
                $('#editDataKaryawan').modal('show');
            @endif

            // Clear validation errors when a modal is closed
            $('#editDataKaryawan, #createDataKaryawan').on('hidden.bs.modal', function() {
                $(this).find('.text-danger').remove();
                $(this).find('.form-control').removeClass('is-invalid');
                $(this).find('form')[0].reset();
            });

            // Handle edit button click to populate and show edit modal
            $('#dataKaryawanTable').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                var $tr = $(this).closest('tr');
                if ($tr.hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();

                // Populate form fields with data from the table
                $('#editDataKaryawan #idEdit').val(data.id_data_karyawan);
                $('#editDataKaryawan #namaEdit').val(data.nama);
                $('#editDataKaryawan #alamatEdit').val(data.alamat);
                $('#editDataKaryawan #nomorTeleponEdit').val(data.nomor_telepon);
                $('#editDataKaryawan #statusKaryawanEdit').val(data.status_karyawan);
                $('#editDataKaryawan #keahlianEdit').val(data.keahlian);
                $('#editDataKaryawan #jabatanEdit').val(data.jabatan);
                $('#editDataKaryawan #usernameEdit').val(data.user.username);
                $('#editDataKaryawan #emailEdit').val(data.user.email);
                $('#editDataKaryawan #roleEdit').val(data.user.role);

                // Dynamically set the form action URL
                var actionUrl = "{{ url('admin/datakaryawan') }}/" + data.id_data_karyawan;
                $('#editDataKaryawan form').attr('action', actionUrl);

                // Show the modal
                $('#editDataKaryawan').modal('show');
            });

            // Handle show button click to populate and show detail modal
            $('#dataKaryawanTable').on('click', '.btn-show', function(event) {
                event.preventDefault();
                var $tr = $(this).closest('tr');
                if ($tr.hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();

                // Populate detail view with data
                $('#showDataKaryawan #namaShow').text(data.nama);
                $('#showDataKaryawan #alamatShow').text(data.alamat);
                $('#showDataKaryawan #nomorTeleponShow').text(data.nomor_telepon);
                $('#showDataKaryawan #statusKaryawanShow').text(data.status_karyawan);
                $('#showDataKaryawan #keahlianShow').text(data.keahlian);
                $('#showDataKaryawan #jabatanShow').text(data.jabatan);

                // Show the modal
                $('#showDataKaryawan').modal('show');
            });

            // Handle delete button click with SweetAlert confirmation
            $(".datatable").on("click", ".btn-delete", function(e) {
                e.preventDefault();
                var form = $(this).closest("form");
                var nama = $(this).data("nama");

                Swal.fire({
                    title: "Apakah anda yakin ingin menghapus data <br><strong>" + nama + "</strong>?",
                    text: "Anda tidak bisa mengembalikan data setelah terhapus!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "bg-primary",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Tidak, batalkan."
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
