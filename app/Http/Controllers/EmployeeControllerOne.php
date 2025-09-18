<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Cuti;
use App\Models\DataKaryawan;
use App\Models\Notifikasi;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

// kontroller pengajuan cuti
class EmployeeControllerOne extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        confirmDelete();
        
        // Mendapatkan ID pengguna yang sedang login dari session
        $userId = Auth::id();

        $dataKaryawan = DataKaryawan::where('user_id', $userId)->first();
        
        // Dapatkan tahun sekarang
        $yearnow = now()->year;
        
        // Cek jumlah hari pengajuan cuti yang untuk tahun yang sama dengan $yearnow
        $jumlahCuti = Cuti::where('data_karyawan_id', $dataKaryawan->id_data_karyawan)
            ->whereYear('mulai_cuti', $yearnow)
            ->whereYear('selesai_cuti', $yearnow)
            ->sum('jumlah_hari');

        return view('employee.pengajuancuti.index', compact('jumlahCuti'));
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
        $messages = [
            'required' => ':attribute harus diisi.',
            'numeric' => 'Isi :attribute dengan angka',
            'date' => 'Isi :attribute dengan format tanggal yang benar',
            'after_or_equal' => 'Harap pilih tanggal untuk hari ini atau setelahnya',
            'mulaiCuti.year' => 'Tanggal mulai cuti harus berada di tahun ini.',
            'selesaiCuti.year' => 'Tanggal selesai cuti harus berada di tahun ini.',
        ];
        
        $validator = Validator::make($request->all(), [
            'mulaiCuti' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $year = Carbon::parse($value)->year;
                    if ($year != Carbon::now()->year) {
                        $fail("Tanggal mulai harus berada di tahun ini.");
                    }
                },
            ],
            'selesaiCuti' => [
                'required',
                'date',
                'after_or_equal:mulaiCuti',
                function ($attribute, $value, $fail) {
                    $year = Carbon::parse($value)->year;
                    if ($year != Carbon::now()->year) {
                        $fail("Tanggal selesai harus berada di tahun ini.");
                    }
                },
            ],
            'keterangan' => 'required',
        ], $messages);
        
         // Mendapatkan ID pengguna yang sedang login dari session
        $userId = Auth::id();

        $dataKaryawan = DataKaryawan::where('user_id', $userId)->first();
        
        $validator->after(function ($validator) use ($request, $dataKaryawan) {
            $yearnow = Carbon::now()->year;
        
            // Hitung total hari cuti yang sudah diambil pada tahun ini
            $totalCutiSaatIni = Cuti::where('data_karyawan_id', $dataKaryawan->id_data_karyawan)
                ->whereYear('mulai_cuti', $yearnow)
                ->whereYear('selesai_cuti', $yearnow)
                ->sum('jumlah_hari');
        
            // Hitung jumlah hari cuti dari pengajuan baru
            $mulaiCuti = Carbon::parse($request->mulaiCuti);
            $selesaiCuti = Carbon::parse($request->selesaiCuti);
            $jumlahHariCutiBaru = $selesaiCuti->diffInDays($mulaiCuti) + 1;
        
            // Tentukan batas maksimal cuti tahunan  7 hari
            $batasCutiTahunan = 7;
        
            // Validasi jika total cuti melebihi batas maksimal
            if (($totalCutiSaatIni + $jumlahHariCutiBaru) > $batasCutiTahunan) {
                $validator->errors()->add('selesaiCuti', 'Jumlah hari cuti melebihi batas cuti tahunan yang diizinkan.');
            }
        });
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 1);
        }
        
        
        // Dapatkan tahun sekarang
        $yearnow = now()->year;
        
        // Cek pengajuan cuti yang telah disetujui untuk tahun yang sama dengan $yearnow
        $jumlahCuti = Cuti::where('data_karyawan_id', $dataKaryawan->id_data_karyawan)
            ->whereYear('mulai_cuti', $yearnow)
            ->whereYear('selesai_cuti', $yearnow)
            ->sum('jumlah_hari');
            
        if($jumlahCuti >= 7){
            Alert::error('Gagal mengajukan cuti', 'Kamu sudah mengajukan cuti dengan batas maksimum pada tahun ini!');

            return redirect()->route('pengajuancuti.index');
        }
        
        // Menghitung jumlah hari cuti
        $mulaiCuti = Carbon::parse($request->mulaiCuti);
        $selesaiCuti = Carbon::parse($request->selesaiCuti);
        $jumlahHariCuti = $selesaiCuti->diffInDays($mulaiCuti) + 1;

        // ELOQUENT DATA PENGAJUAN CUTI
        $datapengajuancuti = new Cuti;
        $datapengajuancuti->mulai_cuti = $request->mulaiCuti;
        $datapengajuancuti->selesai_cuti = $request->selesaiCuti;
        $datapengajuancuti->jumlah_hari = $jumlahHariCuti;
        $datapengajuancuti->keterangan = $request->keterangan;
        $datapengajuancuti->status_cuti = 'Pending';
        $datapengajuancuti->data_karyawan_id = $dataKaryawan->id_data_karyawan;
        $datapengajuancuti->save();

        // Dapatkan semua pengguna di tabel users dengan peran 'Administrator'
        $adminUsers = User::where('role', 'Administrator')->get();

        // Iterasi melalui setiap pengguna administrator
        foreach ($adminUsers as $adminUser) {
            $mulaicutiparse = Carbon::parse($request->mulaiCuti)->locale('id')->isoFormat('DD MMMM YYYY');

            $selesaicutiparse = Carbon::parse($request->selesaiCuti)->locale('id')->isoFormat('DD MMMM YYYY');

            // Mulai mengirimkan notifikasi
            $notifikasi = new Notifikasi;
            $notifikasi->pesan = $dataKaryawan->nama . ' mengajukan cuti untuk tanggal ' . $mulaicutiparse . ' sampai tanggal ' . $selesaicutiparse . ' selengkapnya bisa dicek pada halaman persetujuan cuti.';
            // Mengisi atribut jam dan tanggal dengan waktu saat ini
            $notifikasi->jam = Carbon::now()->toTimeString(); // Format waktu (jam, menit, detik)
            $notifikasi->tanggal = Carbon::now()->toDateString(); // Format tanggal (tahun, bulan, hari)
            $notifikasi->user_id = $adminUser->id_user; // Mengisi user_id dengan ID pengguna administrator
            $notifikasi->save(); // Simpan notifikasi ke database
        }

        Alert::success('Berhasil diajukan', 'Data cuti berhasil diajukan!');

        return redirect()->route('pengajuancuti.index');

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
        //
    }

    public function getData(Request $request)
    {
        // Mendapatkan ID pengguna yang sedang login dari session
        $userId = Auth::id();

        $dataKaryawanId = DataKaryawan::where('user_id', $userId)->pluck('id_data_karyawan')->first();

        // Mencari data persetujuan cuti berdasarkan ID pengguna
        $datapengajuancuti = Cuti::where('data_karyawan_id', $dataKaryawanId);

        if ($request->ajax()) {
            // Jika data kosong, pastikan mengembalikan format JSON yang benar
            if ($datapengajuancuti->count() <= 0) {
                return response()->json([
                    'draw' => intval($request->input('draw')),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                ]);
            }

            return datatables()->of($datapengajuancuti)
                ->addIndexColumn()
                ->addColumn('actions', function () {
                    return view('employee.pengajuancuti.actions');
                })
                ->toJson();
        }

    }
}
