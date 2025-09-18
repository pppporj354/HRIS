@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-3 mb-3">
            <div class="card-header">Riwayat Pengajuan Cuti || Sisa pengajuan cuti tahun ini : {{7 - $jumlahCuti}}</div>
            <div class="card-body d-flex justify-content-end">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createPengajuanCuti">
                            <i class="bi bi-plus-circle me-1"></i><span>Ajukan Cuti</span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                    id="dataPengajuanCutiTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>No</th>
                            <th>Mulai Cuti</th>
                            <th>Selesai Cuti</th>
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

    <!-- modal create -->
    <div class="modal fade" id="createPengajuanCuti" tabindex="-1" aria-labelledby="createPengajuanCutiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('pengajuancuti.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPengajuanCutiModalLabel">Pengajuan Cuti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="mulaiCuti" class="form-label">Mulai Cuti</label>
                            <input class="form-control @error('mulaiCuti') is-invalid @enderror" type="date"
                                name="mulaiCuti" id="mulaiCuti" value="{{ old('mulaiCuti') }}"
                                placeholder="Masukkan tanggal mulai cuti, format (yyyy-mm-dd)">
                            @error('mulaiCuti')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="selesaiCuti" class="form-label">Selesai Cuti</label>
                            <input class="form-control @error('selesaiCuti') is-invalid @enderror" type="date"
                                name="selesaiCuti" id="selesaiCuti" value="{{ old('selesaiCuti') }}"
                                placeholder="Masukkan tanggal selesai cuti, format (yyyy-mm-dd)">
                            @error('selesaiCuti')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" rows="3" name="keterangan"
                                id="keterangan" placeholder="Masukkan keterangan terkait pengambilan cuti">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-create">Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal detail / show -->
    <div class="modal fade" id="showPengajuanCuti" tabindex="-1" aria-labelledby="showPengajuanCutiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="showPengajuanCutiModalLabel">Detail Pengajuan Cuti</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="mulaiCuti" class="form-label">Mulai Cuti</label>
                        <input class="form-control @error('mulaiCuti') is-invalid @enderror" type="date" name="mulaiCuti"
                            id="mulaiCuti" disabled>
                        @error('mulaiCuti')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="selesaiCuti" class="form-label">Selesai Cuti</label>
                        <input class="form-control @error('selesaiCuti') is-invalid @enderror" type="date"
                            name="selesaiCuti" id="selesaiCuti" disabled>
                        @error('selesaiCuti')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" rows="3" name="keterangan"
                            id="keterangan" disabled></textarea>
                        @error('keterangan')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="statusCuti" class="form-label">Status Cuti</label>
                        <select class="form-control @error('statusCuti') is-invalid @enderror" name="statusCuti"
                            id="statusCuti" disabled>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Pending">Pending</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                        @error('statusCuti')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- end modal section --}}
@endsection
@push('scripts')
    <script type="module">
        $(document).ready(function() {
            var table = $("#dataPengajuanCutiTable").DataTable({
                serverSide: true,
                processing: true,
                ajax: "/getPengajuanCuti",
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
                        orderable: false,
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
                    emptyTable: "Belum terdapat riwayat pengajuan cuti yang tercatat!"
                }
            });

            // show createPengajuanCuti modal to show if controller validation pass error message
            @if (!empty(Session::get('error_in_modal')) && Session::get('error_in_modal') == 1)
                $('#createPengajuanCuti').modal('show');
            @endif

            // show form with bootstrap modal
            $('#dataPengajuanCutiTable').on('click', '.btn-show', function(event) {
                event.preventDefault();
                var $tr = $(this).closest('tr');
                if ($tr.hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();

                // Populate your show modal with data
                $('#showPengajuanCuti input[name="mulaiCuti"]').val(data.mulai_cuti);
                $('#showPengajuanCuti input[name="selesaiCuti"]').val(data.selesai_cuti);
                $('#showPengajuanCuti textarea[name="keterangan"]').val(data.keterangan);
                $('#showPengajuanCuti select[name="statusCuti"]').val(data.status_cuti);
            });

            // leave application confirmation with sweetalert by realrashid
            $(".btn-create").on("click", function(e) {
                e.preventDefault();
                var form = $(this).closest("form");

                Swal.fire({
                    title: "Yakin ingin mengajukan cuti?",
                    text: "Anda tidak bisa mengembalikan data cuti yang telah anda ajukan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "bg-primary",
                    confirmButtonText: "Ya, ajukan cuti!",
                    cancelButtonText: "Tidak, jangan ajukan!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

        });
    </script>
@endpush
