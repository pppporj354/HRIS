<?php

namespace App\Exports;

use App\Models\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DaftarAbsensiExport implements FromView, WithStyles, ShouldAutoSize
{
    protected $tgl_mulai;
    protected $tgl_sampai;

    public function __construct($tgl_mulai, $tgl_sampai)
    {
        $this->tgl_mulai = $tgl_mulai;
        $this->tgl_sampai = $tgl_sampai;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
    public function view(): View
    {
        $absensi = Absensi::with('dataKaryawan')
            ->whereBetween('tanggal', [$this->tgl_mulai, $this->tgl_sampai])
            ->get();

        return view('admin.daftarabsensi.export_excel', [
            'absensi' => $absensi,
        ]);
    }
}
