<?php

namespace App\Exports;

use App\Models\DataKaryawan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataKaryawanExport implements FromView, WithStyles, ShouldAutoSize
{
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
    public function view(): View
    {
        return view('admin.datakaryawan.export_excel', [
            'datakaryawan' => DataKaryawan::all(),
        ]);
    }
}
