{{--
    DataTable Card Component
    Parameters:
    - $title: The title of the card
    - $id: The ID of the table
    - $columns: Array of column names for the table header
    - $actions: Slot for action buttons
--}}

<div class="dashboard-card mb-4">
    <div class="card-header">
        <h5>{{ $title }}</h5>
        <div class="d-flex">
            {{ $actions ?? '' }}
        </div>
    </div>
    <div class="card-body" style="overflow-x:auto;">
        <table class="table table-hover mb-0 datatable" id="{{ $id }}">
            <thead>
                <tr>
                    @foreach($columns as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
        </table>
    </div>
</div>
