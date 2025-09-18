<?php

namespace App\Http\Controllers;

use Alert;
use App\Exports\PenggajianExport;
use App\Models\Absensi;
use App\Models\DataKaryawan;
use App\Models\Gaji;
use App\Models\KomponenGaji;
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Validator;

// controller for penggajian
class AdminControllerFive extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datakaryawan = DataKaryawan::all();

        return view('admin.penggajian.index', compact('datakaryawan'));
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
            'required' => ':Attribute harus diisi.',
            'numeric' => 'Isi :attribute dengan angka',
            'min' => "Isi dengan angka / nominal minimal 0",
            'bulanDigaji.regex' => 'Bulan digaji harus memiliki format yyyy-mm.',
        ];
        $validator = Validator::make($request->all(), [
            'bulanDigaji' => ['required', 'regex:/^\d{4}-(0[1-9]|1[0-2])$/'],
            'gajiPokok' => 'required|numeric|min:0',
            'tunjangan' => 'required|numeric|min:0',
            'potonganLain' => 'required|numeric|min:0',
            'potonganKetidakhadiran' => 'required|numeric|min:0',
            'totalGaji' => 'required|numeric|min:0',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 4);
        }

        $total_gaji = $request->gajiPokok + $request->tunjangan - $request->potonganLain - $request->potonganKetidakhadiran;

        if ($request->gajiPokok != session('gaji_pokok') || $request->potonganKetidakhadiran != session('potongan_ketidakhadiran') || $request->totalGaji != $total_gaji) {
            return redirect()->back()->withInput()->with([
                'error' => 'Jangan mengubah data gaji pokok, potongan ketidakhadiran, dan juga total gaji untuk menjaga integritas data, refresh halaman untuk kembali membuat data gaji baru. Untuk data gaji pokok dapat diubah pada komponen gaji.',
                'error_in_modal' => 4,
            ]);
        }

        $existingGaji = Gaji::where('tahun_bulan', $request->bulanDigaji)
            ->where('data_karyawan_id', session('id_data_karyawan'))
            ->exists();

        if ($existingGaji) {
            // Jika sudah ada data dengan bulan yang sama, lakukan sesuai kebutuhan,
            // seperti memberikan pesan error atau mengambil tindakan lain.
            Alert::warning('Gagal ditambahkan', 'Data penggajian untuk bulan yang diinputkan sudah ada!');

            return redirect()->route('penggajian.show', session('id_data_karyawan'));
        }

        // ELOQUENT DATA PENGGAJIAN
        $gaji = new Gaji;
        $gaji->gaji_pokok = $request->gajiPokok;
        $gaji->total_tunjangan = $request->tunjangan;
        $gaji->potongan_lain = $request->potonganLain;
        $gaji->potongan_ketidakhadiran = $request->potonganKetidakhadiran;
        $gaji->total_potongan = $request->potonganLain + $request->potonganKetidakhadiran;
        $gaji->total_gaji = $request->totalGaji;
        $gaji->tahun_bulan = $request->bulanDigaji;
        $gaji->status_gaji = 'Kredit';
        $gaji->data_karyawan_id = session('id_data_karyawan');
        if ($request->keterangan !== null) {
            $gaji->keterangan = $request->keterangan;
        }
        $gaji->save();

        Alert::success('Berhasil Ditambahkan', 'Data penggajian berhasil ditambahkan!');

        return redirect()->route('penggajian.show', session('id_data_karyawan'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Simpan ID karyawan ke dalam flash session
        session(['id_data_karyawan' => $id]);

        $satudatakaryawan = DataKaryawan::find($id);
        $komponengajisatukaryawan = KomponenGaji::where('data_karyawan_id', $id)->first();
        $absensisatukaryawan = Absensi::where('data_karyawan_id', $id)->first();

        if (!$satudatakaryawan) {
            Alert::error('Data Tidak Ditemukan', 'Data Karyawan tidak ditemukan!');
            return redirect()->route('penggajian.index');
        }

        // Memanggil sweetalert untuk konfirmasi delete data
        confirmDelete();

        if ($komponengajisatukaryawan) {
            // mengatur session gaji pokok untuk digunakan di valdiasi create dan edit
            session(['gaji_pokok' => $komponengajisatukaryawan->gaji_pokok]);
        }

        return view('admin.penggajian.historyperemployee', compact('satudatakaryawan', 'komponengajisatukaryawan', 'absensisatukaryawan'));
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
        $messages = [
            'required' => 'Kolom ini harus diisi.',
            'numeric' => 'Isi kolom dengan angka',
            'min' => "Isi dengan angka / nominal minimal 0",
        ];
        $validator = Validator::make($request->all(), [
            'totalTunjanganEdit' => 'required|numeric|min:0',
            'potonganLainEdit' => 'required|numeric|min:0',
            'potonganKetidakhadiranEditHidden' => 'required|numeric|min:0',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 5);
        }

        if ($request->potonganKetidakhadiranEditHidden != session('potongan_ketidakhadiran')) {
            return redirect()->back()->withInput()->with([
                'error' => 'Jangan mengubah data gaji pokok, potongan ketidakhadiran, dan juga total gaji untuk menjaga integritas data, refresh halaman untuk kembali membuat data gaji baru. Untuk data gaji pokok dapat diubah pada komponen gaji.',
            ]);
        }

        // Inisiasi pemanggilan data dari database ke variabel
        $gaji = Gaji::find($id);

        $total_gaji = $gaji->gaji_pokok + $request->totalTunjanganEdit - $request->potonganLainEdit - $request->potonganKetidakhadiranEditHidden;

        $total_potongan = $request->potonganLainEdit + $request->potonganKetidakhadiranEditHidden;

        // ELOQUENT Gaji
        $gaji->potongan_lain = $request->potonganLainEdit;
        $gaji->potongan_ketidakhadiran = $request->potonganKetidakhadiranEditHidden;
        $gaji->total_potongan = $total_potongan;
        $gaji->total_tunjangan = $request->totalTunjanganEdit;
        $gaji->total_gaji = $total_gaji;
        if ($request->keteranganEdit) {
            $gaji->keterangan = $request->keteranganEdit;
        }
        $gaji->save();

        Alert::success('Berhasil Disunting', 'Data gaji karyawan telah berhasil disunting!');

        return redirect()->route('penggajian.show', session('id_data_karyawan'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gaji = Gaji::find($id);

        if (empty($gaji)) {
            return redirect()->back();
        }

        $gaji->delete();

        Alert::success('Data Penggajian Dihapus', 'Data penggajian karyawan telah berhasil dihapus!');

        return redirect()->route('penggajian.show', session('id_data_karyawan'));
    }

    public function getData(Request $request)
    {
        $datakaryawan = DataKaryawan::all();

        if ($request->ajax()) {
            return datatables()->of($datakaryawan)
                ->addIndexColumn()
                ->addColumn('aksi', function ($satudatakaryawan) {
                    return view('admin.penggajian.actions', compact('satudatakaryawan'));
                })
                ->toJson();
        }
    }

    public function getDataPerEmployee(Request $request)
    {
        // Ambil nilai ID dari flash session
        $id = session('id_data_karyawan');

        // Cek apakah ID karyawan ada di session
        if (!$id) {
            return response()->json(['error' => 'ID karyawan tidak ditemukan.'], 400);
        }

        // Query dengan syntax yang benar
        $gaji = Gaji::with('dataKaryawan')->where('data_karyawan_id', $id);

        if ($request->ajax()) {
            return datatables()->of($gaji)
                ->addIndexColumn()
                ->addColumn('aksi', function ($satudatagaji) {
                    return view('admin.penggajian.history_actions', compact('satudatagaji'));
                })
                ->toJson();
        }
    }

    public function exportPDF(Request $request)
    {
        $messages = [
            'required' => 'Kolom ini harus diisi.',
            'date_format' => 'Isi :attribute dengan format bulan yang benar.',
            'before_or_equal' => 'Harap pilih bulan saat ini atau bulan sebelumnya.',
            'after_or_equal' => 'Harap pilih bulan setelah atau sama dengan bulan mulai.',
        ];

        $validator = Validator::make($request->all(), [
            'bulanMulaiPDF' => 'required|date_format:Y-m|before_or_equal:today',
            'bulanSampaiPDF' => 'required|date_format:Y-m|before_or_equal:today|after_or_equal:bulanMulaiPDF',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 1);
        }

        $bln_mulai = $request->bulanMulaiPDF;
        $bln_sampai = $request->bulanSampaiPDF;

        $gaji = Gaji::with('dataKaryawan')
            ->whereBetween('tahun_bulan', [$bln_mulai, $bln_sampai])
            ->get();

        // membuat format bulan agar bisa terbaca misal "Juni 2024" bukan "2024-06" dan juga menggunakan bulan dengan bahasa indonesia
        $bln_mulai_text = Carbon::parse($request->bulanMulaiPDF)->locale('id')->translatedFormat('F Y');
        $bln_sampai_text = Carbon::parse($request->bulanSampaiPDF)->locale('id')->translatedFormat('F Y');

        $pdf = PDF::loadView('admin.penggajian.export_pdf', compact('gaji', 'bln_mulai_text', 'bln_sampai_text'));
        return $pdf->download('Riwayat Gaji Karyawan.pdf');
    }

    public function exportExcel(Request $request)
    {
        $messages = [
            'required' => 'Kolom ini harus diisi.',
            'date_format' => 'Isi :attribute dengan format bulan yang benar.',
            'before_or_equal' => 'Harap pilih bulan saat ini atau bulan sebelumnya.',
            'after_or_equal' => 'Harap pilih bulan setelah atau sama dengan bulan mulai.',
        ];

        $validator = Validator::make($request->all(), [
            'bulanMulaiExcel' => 'required|date_format:Y-m|before_or_equal:today',
            'bulanSampaiExcel' => 'required|date_format:Y-m|before_or_equal:today|after_or_equal:bulanMulaiExcel',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 2);
        }

        $bln_mulai = $request->bulanMulaiExcel;
        $bln_sampai = $request->bulanSampaiExcel;

        return Excel::download(new PenggajianExport($bln_mulai, $bln_sampai), 'Riwayat Gaji Karyawan.xlsx');
    }

    public function storeKomponenGaji(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'integer' => 'Isi :attribute dengan angka bilangan bulat',
            'min' => 'Nilai komponen gaji harus sama atau lebih besar dari 0.',
        ];
        $validator = Validator::make($request->all(), [
            'gajiPokokKomponen' => 'required|integer|min:0',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 3);
        }

        // ELOQUENT DATA AKUN
        $komponengaji = new komponengaji;
        $komponengaji->gaji_pokok = $request->gajiPokokKomponen;
        $komponengaji->data_karyawan_id = $request->idKaryawan;
        $komponengaji->save();

        Alert::success('Berhasil Ditambahkan', 'Data komponen gaji berhasil ditambahkan!');

        // mengatur session gaji pokok untuk digunakan di valdiasi create dan edit
        session(['gaji_pokok' => $komponengaji->gaji_pokok]);

        return redirect()->route('penggajian.show', $request->idKaryawan);

    }

    public function updateKomponenGaji(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'integer' => 'Isi :attribute dengan angka bilangan bulat',
            'min' => 'Nilai komponen gaji harus sama atau lebih besar dari 0.',
        ];
        $validator = Validator::make($request->all(), [
            'gajiPokokKomponen' => 'required|integer|min:0',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 3);
        }

        $komponengaji = KomponenGaji::where('data_karyawan_id', $request->idKaryawan)->first();

        if ($komponengaji) {
            $komponengaji->gaji_pokok = $request->gajiPokokKomponen;
            $komponengaji->save();
        } else {
            Alert::error('Data komponen gaji untuk karyawan ini belum ada', 'Coba untuk membuat komponen gaji baru terlebih dahulu!');

            return redirect()->back()->with('error_in_modal', 3);
        }

        Alert::success('Berhasil Diubah', 'Data komponen gaji berhasil diubah!');

        return redirect()->route('penggajian.show', $request->idKaryawan);
    }

    public function kalkulasiPotonganAbsensi(Request $request)
    {
        $id = $request->input('id');
        $bulanDigaji = $request->input('bulanDigaji');

        // Konversi bulanDigaji ke format tanggal
        $startDate = Carbon::parse($bulanDigaji)->startOfMonth();
        $endDate = Carbon::parse($bulanDigaji)->endOfMonth();

        // Hitung jumlah ketidakhadiran (misalnya, status_absensi 'Alpha')
        $jumlahKetidakhadiran = Absensi::where('data_karyawan_id', $id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->where('status_absensi', 'Alpha')
            ->count();

        // ambil data komponen gaji yang memiliki data_karyawan_id sesuai id yang dipass lalu di hitung antara gaji pokok dengan potongan absensi
        $komponengajisatukaryawan = KomponenGaji::where('data_karyawan_id', $id)->first();
        $gajiPokok = $komponengajisatukaryawan->gaji_pokok ?? 0;
        $potonganKetidakhadiran = $jumlahKetidakhadiran * 0.025 * $gajiPokok;

        session(['potongan_ketidakhadiran' => $potonganKetidakhadiran]);

        return response()->json([
            'potonganKetidakhadiran' => $potonganKetidakhadiran,
        ]);
    }

    public function statusGajiQuery(Request $request, String $id)
    {
        // Inisiasi pemanggilan data dari database ke variabel
        $gaji = Gaji::find($id);

        // request->button_value merupakan input hidden yang ada pada form input yang menyimpan data value dari tombol diterima, ditolak, dan proses
        $button_value = $request->button_value;

        // Eloquent kolom status_rekrutmen
        $gaji->status_gaji = $button_value;
        $gaji->save();

        if ($button_value == 'Terbayar') {
            $datakaryawan = DataKaryawan::find($gaji->data_karyawan_id); // query data karyawan berdasarkan data_karyawan_id yang ada pada data gaji yang dicari menggunakan id yang dipass oleh fungsi
            $user = User::find($datakaryawan->user_id); // mencari data user berdasarkan data karyawan yang telah diquery
            $tahunbulan = Carbon::parse($gaji->tahun_bulan)->locale('id')->translatedFormat('F Y'); // translasi bentuk tahun bulan contoh 2002-07 menjadi juli 2002 (format indonesia)
            $notifikasi = new Notifikasi;
            $notifikasi->pesan = "Gaji anda pada bulan " . $tahunbulan . " telah dibayarkan. Selengkapnya bisa dicek pada halaman riwayat gaji.";
            $notifikasi->jam = Carbon::now()->toTimeString();
            $notifikasi->tanggal = Carbon::now()->toDateString();
            $notifikasi->user_id = $user->id_user;
            $notifikasi->save();
            Alert::success('Gaji telah terbayar', 'Gaji karyawan telah terbayar, karyawan dapat mencetak slip gaji!');
        } else {
            Alert::info('Gaji belum terbayar', 'Gaji karyawan masih dalam proses!');
        }

        return redirect()->route('penggajian.show', session('id_data_karyawan'));
    }
}
