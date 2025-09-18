<div class="d-flex">
    <button type="button" class="btn btn-outline-dark btn-sm me-2 btn-show" data-bs-toggle="modal"
        data-bs-target="#showRekrutmen"><i class="bi-person-lines-fill"></i></button>
    <button type="button" class="btn btn-outline-dark btn-sm me-2 btn-edit" data-bs-toggle="modal"
        data-bs-target="#editRekrutmen"><i class="bi-pencil-square"></i></button>
    <div>
        <form action="{{ route('rekrutmen.destroy', $satudatarekrutmen->id_rekrutmen) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-dark btn-sm me-2 btn-delete"
                data-nama="{{ $satudatarekrutmen->nama }}"><i class="bi-trash"></i></button>
        </form>
    </div>
</div>
