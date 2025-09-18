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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tanggalPDFModalLabel">Pilih Bulan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('penggajian.exportPDF') }}" method="POST" id="exportPDFForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bulanMulaiPDF">Mulai</label>
                            <input type="month" class="form-control @error('bulanMulaiPDF') is-invalid @enderror"
                                id="bulanMulaiPDF" name="bulanMulaiPDF" value="{{ old('bulanMulaiPDF') }}">
                            @error('bulanMulaiPDF')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bulanSampaiPDF">Sampai</label>
                            <input type="month" class="form-control @error('bulanSampaiPDF') is-invalid @enderror"
                                id="bulanSampaiPDF" name="bulanSampaiPDF" value="{{ old('bulanSampaiPDF') }}">
                            @error('bulanSampaiPDF')
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
                    <h5 class="modal-title" id="tanggalExcelModalLabel">Pilih Bulan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('penggajian.exportExcel') }}" method="POST" id="exportExcelForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bulanMulaiExcel">Mulai</label>
                            <input type="month" class="form-control @error('bulanMulaiExcel') is-invalid @enderror"
                                id="bulanMulaiExcel" name="bulanMulaiExcel">
                            @error('bulanMulaiExcel')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bulanSampaiExcel">Sampai</label>
                            <input type="month" class="form-control @error('bulanSampaiExcel') is-invalid @enderror"
                                id="bulanSampaiExcel" name="bulanSampaiExcel">
                            @error('bulanSampaiExcel')
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
