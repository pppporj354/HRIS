@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-3 mb-3">
            <div class="card-header">Riwayat Gaji</div>
            <div class="card-body" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                    id="dataRiwayatGajiTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>No</th>
                            <th>Tahun - Bulan</th>
                            <th>Gaji Pokok</th>
                            <th>Total Tunjangan</th>
                            <th>Total Potongan</th>
                            <th>Total Gaji</th>
                            <th>Aksi</th>
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
            var table = $("#dataRiwayatGajiTable").DataTable({
                serverSide: true,
                processing: true,
                ajax: "/getRiwayatGaji",
                columns: [{
                        data: "id_gaji",
                        name: "id_gaji",
                        visible: false
                    },
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "tahun_bulan",
                        name: "tahun_bulan"
                    },
                    {
                        data: "gaji_pokok",
                        name: "gaji_pokok"
                    },
                    {
                        data: "total_tunjangan",
                        name: "total_tunjangan"
                    },
                    {
                        data: "total_potongan",
                        name: "total_potongan"
                    },
                    {
                        data: "total_gaji",
                        name: "total_gaji"
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
                language: {
                    emptyTable: "Belum terdapat riwayat gaji yang tercatat!"
                }
            });
        });
    </script>
@endpush
