<div class="d-flex">
    <button type="button" class="btn btn-outline-dark btn-sm me-2 btn-show" data-bs-toggle="modal"
        data-bs-target="#showPersetujuanCuti"> <i class="bi bi-hand-thumbs-up"></i></button>

    {{-- wrapper + form + button for delete data --}}
    <div id="deletePersetujuanCutiButton">
        <form action="{{ route('persetujuancuti.destroy', $satudatapersetujuancuti->id_cuti) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn-delete btn btn-outline-dark btn-sm me-2 btn-delete"><i class="bi-trash"></i></button>
        </form>
    </div>
</div>
