<div class="d-flex">
    {{-- button print PDF --}}
    <form action="{{ route('riwayatgaji.exportPDF') }}" method="POST" id="exportPDFRiwayatGajiForm"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{ $gajisatukaryawan->id_gaji }}" name="id_gaji">
        <button type="submit" class="btn btn-outline-dark"><i class="bi bi-printer"></i></button>
    </form>
</div>
