<div class="d-flex gap-1 justify-content-end">
    {{-- button show --}}
    <button class="btn btn-sm btn-light btn-show rounded-circle shadow-sm"
            data-bs-toggle="modal"
            data-bs-target="#showDataKaryawan"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="Detail karyawan">
        <i class="bi bi-eye text-primary"></i>
    </button>

    {{-- button edit --}}
    <button class="btn btn-sm btn-light btn-edit rounded-circle shadow-sm"
            data-bs-toggle="modal"
            data-bs-target="#editDataKaryawan"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="Edit karyawan">
        <i class="bi bi-pencil-square text-warning"></i>
    </button>

    {{-- wrapper + form + button for delete data --}}
    <div>
        <form action="{{ route('datakaryawan.destroy', $satudatakaryawan->id_data_karyawan) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit"
                   class="btn-delete btn btn-sm btn-light rounded-circle shadow-sm"
                   data-nama="{{ $satudatakaryawan->nama }}"
                   data-bs-toggle="tooltip"
                   data-bs-placement="top"
                   title="Hapus karyawan">
                <i class="bi bi-trash text-danger"></i>
            </button>
        </form>
    </div>
</div>
