<?php

namespace App\Exports;

use App\Models\Rekrutmen;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataRekrutmenExport implements FromView, WithStyles, ShouldAutoSize
{
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
    public function view(): View
    {
        return view('admin.rekrutmen.export_excel', [
            'datarekrutmen' => Rekrutmen::all(),
        ]);
    }
}
