<?php

namespace App\Http\Controllers;

use Alert;
use App\Exports\DataPersetujuanCutiExport;
use App\Models\Cuti;
use App\Models\DataKaryawan;
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

// controller for persetujuan cuti
class AdminControllerFour extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        confirmDelete();

        return view('admin.persetujuancuti.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cuti = Cuti::find($id);

        if (empty($cuti)) {
            return redirect()->route('persetujuancuti.index');
        }
        $cuti->delete();

        Alert::success('Data Berhasil Dihapus', 'Data persetujuan cuti karyawan telah berhasil dihapus!');

        return redirect()->route('persetujuancuti.index');
    }

    public function getData(Request $request)
    {
        $datapersetujuancuti = Cuti::with('dataKaryawan')->select('cuti.*', 'data_karyawan.nama as nama_karyawan')
            ->join('data_karyawan', 'cuti.data_karyawan_id', '=', 'data_karyawan.id_data_karyawan');
        if ($request->ajax()) {
            return datatables()->of($datapersetujuancuti)
                ->addIndexColumn()
                ->addColumn('actions', function ($satudatapersetujuancuti) {
                    return view('admin.persetujuancuti.actions', compact('satudatapersetujuancuti'));
                })
                ->toJson();
        }
    }

    public function statusCutiQuery(Request $request, String $id)
    {
        // Inisiasi pemanggilan data dari database ke variabel
        $datapersetujuancuti = Cuti::find($id);

        // request->button_value merupakan input hidden yang ada pada form input yang menyimpan data value dari tombol diterima, ditolak, dan proses
        $button_value = $request->button_value;

        // Eloquent kolom status_rekrutmen
        $datapersetujuancuti->status_cuti = $button_value;
        $datapersetujuancuti->save();

        function notifikasi(string $pesan, string $id_cuti)
        {
            // mencari data persetujuan cuti untuk lokal fungsi notifikasi
            $datapersetujuancuti = Cuti::find($id_cuti);
            // Mencari data karyawan untuk diambil user_id nya
            $satudatakaryawan = DataKaryawan::find($datapersetujuancuti->data_karyawan_id);
            // mengambil data user_id dari tabel user
            $satudatauser = User::find($satudatakaryawan->user_id);
            // Mulai mengirimkan notifikasi

            $mulaicutiparse = Carbon::parse($datapersetujuancuti->mulai_cuti)->locale('id')->isoFormat('DD MMMM YYYY');

            $selesaicutiparse = Carbon::parse($datapersetujuancuti->selesai_cuti)->locale('id')->isoFormat('DD MMMM YYYY');

            $notifikasi = new Notifikasi;
            $notifikasi->pesan = "Pengajuan cuti mu untuk tanggal " . $mulaicutiparse . " sampai tanggal " . $selesaicutiparse . " telah " . $pesan;
            // Mengisi atribut jam dan tanggal dengan waktu saat ini
            $notifikasi->jam = Carbon::now()->toTimeString(); // Format waktu (jam, menit, detik)
            $notifikasi->tanggal = Carbon::now()->toDateString(); // Format tanggal (tahun, bulan, hari)
            $notifikasi->user_id = $satudatauser->id_user; // Mengisi user_id dengan ID karyawan yang mengajukan cuti
            $notifikasi->save(); // Simpan notifikasi ke database

        }

        if ($button_value == 'Disetujui') {
            Alert::success('Pengajuan cuti disetujui', 'Pengajuan cuti karyawan diterima!');
            notifikasi('Disetujui', $datapersetujuancuti->id_cuti);
        } else if ($button_value == 'Ditolak') {
            Alert::error('Pengajuan cuti ditolak', 'Pengajuan cuti karyawan ditolak!');
            notifikasi('Ditolak', $datapersetujuancuti->id_cuti);
        } else {
            Alert::info('Pengajuan cuti pending', 'Permohonan pengajuan cuti karyawan masih ditinjau!');
        }

        return redirect()->route('persetujuancuti.index');
    }

    public function exportExcel()
    {
        return Excel::download(new DataPersetujuanCutiExport, 'Data Cuti.xlsx');
    }

    public function exportPDF()
    {
        $datapersetujuancuti = Cuti::with('dataKaryawan')->get();
        $pdf = PDF::loadView('admin.persetujuancuti.export_pdf', compact('datapersetujuancuti'));
        return $pdf->download('Data Cuti.pdf');
    }
}
