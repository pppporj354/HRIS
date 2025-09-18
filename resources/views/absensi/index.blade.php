@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        @if($isAdmin)
                            Kelola Absensi
                        @else
                            Riwayat Absensi Saya
                        @endif
                    </h4>
                    @if($isAdmin)
                        <a href="{{ route('absensi.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Tambah Absensi
                        </a>
                    @else
                        <a href="{{ route('absensi.create') }}" class="btn btn-success">
                            <i class="bi bi-clock"></i> Absen Hari Ini
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="absensiTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    @if($isAdmin)
                                        <th>Nama Karyawan</th>
                                    @endif
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    @if($isAdmin)
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#absensiTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('absensi.getData') }}",
            type: 'GET'
        },
        columns: [
            @if($isAdmin)
            { data: 'nama_karyawan', name: 'dataKaryawan.nama' },
            @endif
            { data: 'tanggal_formatted', name: 'tanggal' },
            { data: 'jam_masuk', name: 'jam_masuk' },
            { data: 'status_badge', name: 'status_absensi', orderable: false, searchable: false },
            { data: 'keterangan', name: 'keterangan' },
            @if($isAdmin)
            { data: 'action', name: 'action', orderable: false, searchable: false }
            @endif
        ],
        order: [[{{ $isAdmin ? 1 : 0 }}, 'desc']],
        language: {
            processing: "Sedang memproses...",
            lengthMenu: "Tampilkan _MENU_ entri",
            zeroRecords: "Tidak ada data yang ditemukan",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
            infoFiltered: "(disaring dari _MAX_ total entri)",
            search: "Cari:",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        }
    });
});
</script>
@endpush