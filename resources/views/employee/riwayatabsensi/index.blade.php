@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-3 mb-3">
            <div class="card-header">Riwayat Absensi</div>
            <div class="card-body" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                    id="dataRiwayatAbsensiTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Status Absensi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="module">
        $(document).ready(function() {
            var table = $("#dataRiwayatAbsensiTable").DataTable({
                serverSide: true,
                processing: true,
                ajax: "/getRiwayatAbsensi",
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
                        data: "status_absensi",
                        name: "status_absensi",
                    },
                    {
                        data: "keterangan",
                        name: "keterangan",
                        orderable: false,
                    },
                ],
                order: [
                    [0, "desc"]
                ],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100,
                        "All"
                    ], // Mengatur menu range jumlah yang data yang dapat ditampilkan
                ],
                pageLength: 50, // Mengatur jumlah entri per halaman secara default
                language: {
                    emptyTable: "Belum terdapat riwayat absensi anda yang tercatat!"
                }
            });
        });
    </script>
@endpush
