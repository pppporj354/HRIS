<?php

namespace App\Exports;

use App\Models\Gaji;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenggajianExport implements FromView, WithStyles, ShouldAutoSize
{
    protected $bln_mulai;
    protected $bln_sampai;

    public function __construct($bln_mulai, $bln_sampai)
    {
        $this->bln_mulai = $bln_mulai;
        $this->bln_sampai = $bln_sampai;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
    public function view(): View
    {
        $gaji = Gaji::with('dataKaryawan')
            ->whereBetween('tahun_bulan', [$this->bln_mulai, $this->bln_sampai])
            ->get();

        return view('admin.penggajian.export_excel', [
            'gaji' => $gaji,
        ]);
    }
}
