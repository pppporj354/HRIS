@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-3 mb-3">
            <div class="card-header">Data Karyawan untuk Penggajian</div>
            <div class="card-body d-flex justify-content-end">
                <ul class="list-inline mb-0">
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

    <!-- Start Modal Tanggal Export PDF -->
    <div class="modal fade" id="tanggalPDFModal" tabindex="-1" aria-labelledby="tanggalPDFModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="tanggalPDFModalLabel">
                        <i class="bi bi-file-pdf text-danger me-2"></i>Export PDF - Pilih Periode
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('penggajian.exportPDF') }}" method="POST" id="exportPDFForm">
                    @csrf
                    <div class="modal-body pt-0">
                        <x-form-section title="Periode Export" icon="calendar-range" color="danger">
                            <x-form-input
                                label="Tanggal Mulai"
                                name="bulanMulaiPDF"
                                type="month"
                                icon="calendar-event"
                                :errors="$errors"
                                required
                            />

                            <x-form-input
                                label="Tanggal Sampai"
                                name="bulanSampaiPDF"
                                type="month"
                                icon="calendar-check"
                                :errors="$errors"
                                required
                            />
                        </x-form-section>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 ms-2" id="exportPDFButton">
                            <i class="bi bi-download me-1"></i>Export PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Tanggal Export PDF -->

    <!-- Start Modal Tanggal Export Excel -->
    <div class="modal fade" id="tanggalExcelModal" tabindex="-1" aria-labelledby="tanggalExcelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="tanggalExcelModalLabel">
                        <i class="bi bi-file-excel text-success me-2"></i>Export Excel - Pilih Periode
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('penggajian.exportExcel') }}" method="POST" id="exportExcelForm">
                    @csrf
                    <div class="modal-body pt-0">
                        <x-form-section title="Periode Export" icon="calendar-range" color="success">
                            <x-form-input
                                label="Tanggal Mulai"
                                name="bulanMulaiExcel"
                                type="month"
                                icon="calendar-event"
                                :errors="$errors"
                                required
                            />

                            <x-form-input
                                label="Tanggal Sampai"
                                name="bulanSampaiExcel"
                                type="month"
                                icon="calendar-check"
                                :errors="$errors"
                                required
                            />
                        </x-form-section>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-pill px-4 ms-2" id="exportExcelButton">
                            <i class="bi bi-download me-1"></i>Export Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Tanggal Export Excel -->
@endsection
@push('scripts')
    <script type="module">
        $(document).ready(function() {
            // show table record with datatable
            var table = $("#dataKaryawanTable").DataTable({
                serverSide: true,
                processing: true,
                ajax: "/getDataKaryawanPenggajian",
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
        });
    </script>
@endpush
