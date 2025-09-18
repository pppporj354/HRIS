<div class="d-flex">
    <div id="printPDFSlipGajiPerKaryawanButton">
        {{-- button print PDF --}}
        <form action="{{ route('riwayatgaji.exportPDF') }}" method="POST" id="exportPDFRiwayatGajiForm"
            enctype="multipart/form-data" target="_blank">
            @csrf
            <input type="hidden" value="{{ $satudatagaji->id_gaji }}" name="id_gaji">
            <button type="submit" class="btn btn-outline-dark btn-sm me-2 btn-print"><i
                    class="bi bi-printer"></i></button>
        </form>
    </div>

    {{-- button show --}}
    <button class="btn btn-outline-dark btn-sm me-2 btn-show" data-bs-toggle="modal"
        data-bs-target="#showPenggajianPerKaryawanModal"><i class="bi-person-lines-fill"></i></button>

    {{-- button edit --}}
    <button class="btn btn-outline-dark btn-sm me-2 btn-edit" data-bs-toggle="modal"
        data-bs-target="#editPenggajianPerKaryawanModal"><i class="bi-pencil-square"></i></button>

    {{-- wrapper + form + button for delete data --}}
    <div id="deletePenggajianPerKaryawanButton">
        <form action="{{ route('penggajian.destroy', $satudatagaji->id_gaji) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn-delete btn btn-outline-dark btn-sm me-2 btn-delete"
                data-nama="{{ $satudatagaji->id_gaji }}"><i class="bi-trash"></i></button>
        </form>
    </div>
</div>
