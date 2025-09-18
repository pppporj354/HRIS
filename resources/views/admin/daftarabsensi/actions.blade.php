<div class="d-flex">
    {{-- button show --}}
    <button class="btn btn-outline-dark btn-sm me-2 btn-show" data-bs-toggle="modal"
        data-bs-target="#showDaftarAbsensiModal"><i class="bi-person-lines-fill"></i></button>

    {{-- button edit --}}
    <button class="btn btn-outline-dark btn-sm me-2 btn-edit" data-bs-toggle="modal"
        data-bs-target="#editDaftarAbsensiModal"><i class="bi-pencil-square"></i></button>

    {{-- wrapper + form + button for delete data --}}
    <div>
        <form action="{{ route('daftarabsensi.destroy', $satudatadaftarabsensi->id_absensi) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn-delete btn btn-outline-dark btn-sm me-2 btn-delete"
                data-nama="{{ $satudatadaftarabsensi->dataKaryawan->nama }}"><i class="bi-trash"></i></button>
        </form>
    </div>
</div>
