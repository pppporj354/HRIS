@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-3 mb-3">
            <div class="card-header">Data Permohonan Cuti</div>
            <div class="card-body d-flex justify-content-end">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a href="{{ route('persetujuancuti.exportExcel') }}" class="btn btn-outline-success">
                            <i class="bi bi-download me-1"></i><span>Excel</span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ route('persetujuancuti.exportPDF') }}" class="btn btn-outline-danger">
                            <i class="bi bi-download me-1"></i><span>PDF</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                    id="dataPersetujuanCutiTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>No</th>
                            <th>Pemohon</th>
                            <th>Tanggal Mulai Cuti</th>
                            <th>Tanggal Selesai Cuti</th>
                            <th>Keterangan</th>
                            <th>Status Cuti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>

    {{-- start modal section --}}

    {{-- modal detail / show --}}
    <div class="modal fade" id="showPersetujuanCuti" tabindex="-1" aria-labelledby="showPersetujuanCutiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="showPersetujuanCutiModalLabel">Persetujuan Permohonan Cuti Karyawan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="pemohon" class="form-label">Pemohon</label>
                        <input class="form-control @error('pemohon') is-invalid @enderror" type="text" name="pemohon"
                            id="pemohon" disabled>

                    </div>
                    <div class="form-group">
                        <label for="mulaiCuti" class="form-label">Tanggal Mulai Cuti</label>
                        <input class="form-control @error('mulaiCuti') is-invalid @enderror" type="text" name="mulaiCuti"
                            id="mulaiCuti" disabled>

                    </div>
                    <div class="form-group">
                        <label for="selesaiCuti" class="form-label">Tanggal Selesai Cuti</label>
                        <input class="form-control @error('selesaiCuti') is-invalid @enderror" type="text"
                            name="selesaiCuti" id="selesaiCuti" disabled>

                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input class="form-control @error('keterangan') is-invalid @enderror" type="text"
                            name="keterangan" id="keterangan" disabled>

                    </div>
                    <div class="form-group mt-1">
                        <label for="statusCuti" class="form-label">Status Cuti</label>
                        <input class="form-control @error('statusCuti') is-invalid @enderror" type="text"
                            name="statusCuti" id="statusCuti" disabled>

                    </div>
                    <div class="modal-footer p-0 justify-content-center justify-content-md-end mt-2">
                        <form action="{{ route('rekrutmen.statusRekrutmenQuery', ':id') }}" method="POST"
                            enctype="multipart/form-data" id="statusCutiQueryForm">
                            @csrf
                            <input type="hidden" name="button_value" id="button_value">
                            <button type="button" class="btn btn-success btnquery" value="Disetujui"><i
                                    class="bi bi-check-circle"></i><span class="ms-1">Setujui</span></button>
                            <button type="button" class="btn btn-primary btnquery" value="Pending"><i
                                    class="bi bi-clock"></i><span class="ms-1">Pending</span></button>
                            <button type="button" class="btn btn-danger btnquery" value="Ditolak"><i
                                    class="bi bi-x-circle"></i><span class="ms-1">Tolak</span></button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        {{-- end modal section --}}
    @endsection
    @push('scripts')
        {{-- {{ $dataTable->scripts() }} --}}
        <script type="module">
            $(document).ready(function() {
                var table = $("#dataPersetujuanCutiTable").DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: "/getPersetujuanCuti",
                    columns: [{
                            data: "id_cuti",
                            name: "id_cuti",
                            visible: false
                        },
                        {
                            data: "DT_RowIndex",
                            name: "DT_RowIndex",
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: "nama_karyawan",
                            name: "data_karyawan.nama"
                        },
                        {
                            data: "mulai_cuti",
                            name: "mulai_cuti"
                        },
                        {
                            data: "selesai_cuti",
                            name: "selesai_cuti"
                        },
                        {
                            data: "keterangan",
                            name: "keterangan",
                            orderable: false,
                        },
                        {
                            data: "status_cuti",
                            name: "status_cuti",
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
                        emptyTable: "Belum terdapat data permohonan cuti yang tercatat!"
                    }
                });

                // show form with bootstrap modal
                $('#dataPersetujuanCutiTable').on('click', '.btn-show', function(event) {
                    event.preventDefault();
                    var $tr = $(this).closest('tr');
                    if ($tr.hasClass('child')) {
                        $tr = $tr.prev('.parent');
                    }

                    var data = table.row($tr).data();

                    // Populate your show modal with data
                    $('#showPersetujuanCuti input[name="nama"]').val(data.nama);
                    $('#showPersetujuanCuti input[name="pemohon"]').val(data.data_karyawan.nama);
                    $('#showPersetujuanCuti input[name="mulaiCuti"]').val(data.mulai_cuti);
                    $('#showPersetujuanCuti input[name="selesaiCuti"]').val(data.selesai_cuti);
                    $('#showPersetujuanCuti input[name="keterangan"]').val(data.keterangan);
                    $('#showPersetujuanCuti input[name="statusCuti"]').val(data.status_cuti);

                    var updateRoute = "{{ route('persetujuancuti.statusCutiQuery', ':id') }}";
                    updateRoute = updateRoute.replace(':id', data.id_cuti); // Perubahan ini harus disimpan

                    // Set form action URL dynamically
                    var actionUrl = '/statusCutiQuery/' + data.id_cuti;
                    $('#showPersetujuanCuti form').attr('action', actionUrl);
                });

                // Menangani klik pada tombol tolak, terima, dan proses pada detail modal
                $('#statusCutiQueryForm .btnquery').click(function() {
                    var buttonValue = $(this).val(); // Mendapatkan nilai tombol yang diklik
                    $('#button_value').val(buttonValue); // Mengatur nilai input hidden

                    // Melakukan submit form
                    var form = $(this).closest("form");
                    form.submit();
                });

                // delete confirmation with sweetalert by realrashid
                $(".datatable").on("click", ".btn-delete", function(e) {
                    e.preventDefault();
                    var form = $(this).closest("form");

                    Swal.fire({
                        title: "Apakah anda yakin ingin menghapus data persetujuan cuti ini ?",
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
