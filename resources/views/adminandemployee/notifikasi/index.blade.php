@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center">
        <div class="card d-flex flex-column align-items-center p-3 mt-3 mb-3 col-12 col-md-8"
            style="overflow-y: auto; max-height: 85vh;">
            <div class="d-flex justify-content-between align-items-center w-100 mb-3">
                <h5 class="mb-0">Notifikasi</h5>
                <form action="{{ route('notifikasi.destroy', $userId) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-secondary btn-delete"><i class="bi bi-trash3"></i>Bersihkan</button>
                </form>
            </div>
            @if ($notifikasi->isEmpty())
                <div class="card w-100">
                    <div class="card-body">
                        <p>Tidak ada notifikasi.</p>
                    </div>
                </div>
            @else
                @foreach ($notifikasi as $notif)
                    <div class="card mb-3 w-100">
                        <div class="card-header d-flex justify-content-between">
                            <div>
                                <strong>Pengirim :</strong> Sistem
                            </div>
                            <div>
                                <small class="text-muted">{{ $notif->jam . ' | ' . $notif->tanggal }}</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>{{ $notif->pesan }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
@push('scripts')
    <script type="module">
        $(document).ready(function() {
            // delete confirmation with sweetalert by realrashid
            $(".btn-delete").on("click", function(e) {
                e.preventDefault();
                var form = $(this).closest("form");
                var nama = $(this).data("nama");

                Swal.fire({
                    title: "Yakin ingin membersihkan data notifikasi?",
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
