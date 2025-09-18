<?php

namespace App\Http\Controllers;

use Alert;
use App\Exports\DaftarAbsensiExport;
use App\Models\Absensi;
use App\Models\DataKaryawan;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Validator;

// controller for daftarabsensi
class AdminControllerThree extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absensi = Absensi::with('dataKaryawan')->get();
        confirmDelete(); // untuk konfirmasi delete dan juga trigger sweetalert di index
        return view('admin.daftarabsensi.index', compact('absensi'));
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
        $messages = [
            'required' => 'Kolom tersebut harus diisi.',
            'jamMasukEdit.required' => 'Jam masuk harus diisi.',
            'jamMasukEdit.regex' => 'Jam masuk harus pada jam 00:00.',
        ];
        $validator = Validator::make($request->all(), [
            'keteranganEdit' => 'required',
            'statusAbsensiEdit' => 'required',
            'jamMasukEdit' => [
                'required',
                'regex:/^00:00:00$/',
            ],
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 4)->with('error_id_absensi', $id);
        }

        // Inisiasi pemanggilan data dari database ke variabel
        $daftarabsensi = Absensi::find($id);

        // ELOQUENT Daftar Absensi
        $daftarabsensi->keterangan = $request->keteranganEdit;
        $daftarabsensi->status_absensi = $request->statusAbsensiEdit;
        $daftarabsensi->save();

        Alert::success('Berhasil Disunting', 'Data pada daftar absensi berhasil disunting!');

        return redirect()->route('daftarabsensi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $daftarabsensi = Absensi::find($id);

        if (empty($daftarabsensi)) {
            return redirect()->back();
        }

        $daftarabsensi->delete();

        Alert::success('Data Absensi Dihapus', 'Data absensi karyawan telah berhasil dihapus!');

        return redirect()->route('daftarabsensi.index');

    }

    public function getData(Request $request)
    {
        $datadaftarabsensi = Absensi::with('dataKaryawan')->select('absensi.*', 'data_karyawan.nama as nama_karyawan')
            ->join('data_karyawan', 'absensi.data_karyawan_id', '=', 'data_karyawan.id_data_karyawan');
        if ($request->ajax()) {
            return datatables()->of($datadaftarabsensi)
                ->addIndexColumn()
                ->addColumn('actions', function ($satudatadaftarabsensi) {
                    return view('admin.daftarabsensi.actions', compact('satudatadaftarabsensi'));
                })
                ->toJson();
        }
    }

    public function generateAbsenceData(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'date' => 'Masukkan data dalam bentuk tanggal yang benar',
        ];
        $validator = Validator::make($request->all(), [
            'tanggalGenerate' => 'required|date',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 1);
        }

        $datakaryawan = DataKaryawan::all();
        $tanggal = $request->input('tanggalGenerate');

        foreach ($datakaryawan as $dk) {
            // Periksa apakah entri absensi dengan tanggal dan data karyawan yang sama sudah ada
            $existingAbsensi = Absensi::where('tanggal', $tanggal)
                ->where('data_karyawan_id', $dk->id_data_karyawan)
                ->exists();

            if (!$existingAbsensi) {
                // ELOQUENT DATA KARYAWAN
                $daftarabsensi = new Absensi;
                $daftarabsensi->tanggal = $tanggal;
                $daftarabsensi->jam_masuk = '00:00:00';
                $daftarabsensi->status_absensi = 'Alpha';
                $daftarabsensi->keterangan = '';
                $daftarabsensi->data_karyawan_id = $dk->id_data_karyawan;
                $daftarabsensi->save();
            }
        }

        Alert::success('Berhasil Generate Daftar Absensi Karyawan', 'Berhasil generate data absen karyawan untuk tanggal yang telah ditentukan!');
        return redirect()->route('daftarabsensi.index');
    }

    public function exportPDF(Request $request)
    {
        $messages = [
            'required' => 'kolom ini harus diisi.',
            'date' => 'Isi :attribute dengan format tanggal yang benar',
            'after_or_equal' => 'Harap pilih tanggal setelah atau sama dengan tanggal mulai',
            'before_or_equal' => 'Harap pilih tanggal saat ini atau tanggal sebelumnya',
        ];
        $validator = Validator::make($request->all(), [
            'tanggalMulaiPDF' => 'required|date|before_or_equal:today',
            'tanggalSampaiPDF' => 'required|date|before_or_equal:today|after_or_equal:tanggalMulaiPDF',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 2);
        }

        $tgl_mulai = $request->tanggalMulaiPDF;
        $tgl_sampai = $request->tanggalSampaiPDF;

        $absensi = Absensi::with('dataKaryawan')
            ->whereBetween('tanggal', [$tgl_mulai, $tgl_sampai])
            ->get();

        // membuat format tanggal agar bisa terbaca misal "19 Juni 2024" bukan "2024-06-19" dan juga menggunakan bulan dengan bahasa indonesia
        $tgl_mulai_text = Carbon::parse($request->tanggalMulaiPDF)->locale('id')->translatedFormat('d F Y');
        $tgl_sampai_text = Carbon::parse($request->tanggalSampaiPDF)->locale('id')->translatedFormat('d F Y');

        $pdf = PDF::loadView('admin.daftarabsensi.export_pdf', compact('absensi', 'tgl_mulai_text', 'tgl_sampai_text'));
        return $pdf->download('Daftar Absensi.pdf');
    }

    public function exportExcel(Request $request)
    {
        $messages = [
            'required' => 'kolom ini harus diisi.',
            'date' => 'Isi :attribute dengan format tanggal yang benar',
            'after_or_equal' => 'Harap pilih tanggal setelah atau sama dengan tanggal mulai',
            'before_or_equal' => 'Harap pilih tanggal saat ini atau tanggal sebelumnya',
        ];
        $validator = Validator::make($request->all(), [
            'tanggalMulaiExcel' => 'required|date|before_or_equal:today',
            'tanggalSampaiExcel' => 'required|date|before_or_equal:today|after_or_equal:tanggalMulaiExcel',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 3);
        }

        $tgl_mulai = $request->tanggalMulaiExcel;
        $tgl_sampai = $request->tanggalSampaiExcel;

        return Excel::download(new DaftarAbsensiExport($tgl_mulai, $tgl_sampai), 'Daftar Absensi.xlsx');
    }

    // start function for absensi features
    public function showLoginAbsensiForm()
    {
        return view('admin.daftarabsensi.loginabsensi');
    }

    public function authenticationAbsensiForm(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
        ];
        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->password === env('MASTER_PASSWORD')) {
            // melogout dari akun utama dan masuk dengan akun master aplikasi untuk melakukan absensi agar tidak terjadi login ganda dan mencegah karyawan untuk bisa memback aplikasi ketika ditinggalkan untuk dipakai login
            Auth::logout();
            $request->session()->put('master_authenticated', true);
            return redirect()->route('daftarabsensi.absensi');
        } else {
            return redirect()->back()->withErrors(['password' => 'Master password is incorrect']);
        }

    }

    public function absensi()
    {

        // Mengatur lokal Carbon ke bahasa Indonesia
        Carbon::setLocale('id');

        $tanggalsaatini = Carbon::today()->translatedFormat('d F Y');

        return view('admin.daftarabsensi.absensi', compact('tanggalsaatini'));
    }

    public function catatAbsensi(Request $request)
    {
        // validasi input data dimana menerima baik username ataupun password
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // menentukan dengan kode dibawah ini apakah yang diinputkan termasuk email atau username, jika return true maka itu adalah email dan jika false maka dianggap sebagai usename
        $filterUserOrEmail = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // menyiapkan kredensial untuk memulai autentikasi setelah mendapatkan login menggunakan email atau username
        $authCredentials = [
            $filterUserOrEmail => $credentials['login'],
            'password' => $credentials['password'],
        ];

        if (Auth::attempt($authCredentials)) {
            // langsung logout setelah melakukan login hanya untuk pengecekan data absensi
            Auth::logout();
            
            $datakaryawan = DataKaryawan::whereHas('user', function ($query) use ($filterUserOrEmail, $authCredentials) {
                $query->where($filterUserOrEmail, $authCredentials[$filterUserOrEmail]);
            })->first();

            // setting carbon agar timezone sesuai timezone WIB
            $today = Carbon::today()->setTimezone('Asia/Jakarta');
            $now = Carbon::now()->setTimezone('Asia/Jakarta');

            // Cari Absensi untuk data karyawan dan tanggal hari ini dan yang masuk
            $absensi = Absensi::where('data_karyawan_id', $datakaryawan->id_data_karyawan)
                ->where('status_absensi', 'Masuk')
                ->whereDate('tanggal', $today)
                ->first();
                
            // Cari Absensi untuk data karyawan dan tanggal hari ini saja
            $absensitoday = Absensi::where('data_karyawan_id', $datakaryawan->id_data_karyawan)
                ->whereDate('tanggal', $today)
                ->first();

            if ($absensi) {
                // Jika sudah ada entri untuk hari ini, update kolom jam_masuk dengan waktu saat ini
                Alert::success('Sudah Absen', 'Anda sudah melakukan absen untuk hari ini, cek absensi anda di sebelah kanan halaman ini!');
            return redirect()->route('daftarabsensi.absensi');
            } else if ($absensitoday) {
                // Jika sudah ada entri untuk hari ini
                // Inisiasi pemanggilan data dari database ke variabel
                $updateabsensi = Absensi::find($absensitoday->id_absensi);

                // ELOQUENT Daftar Absensi
                $updateabsensi->jam_masuk = $now;
                $updateabsensi->status_absensi = 'Masuk';
                $updateabsensi->save();
            } else {
                // Jika belum ada entri untuk hari ini, buat entri baru
                $absensi = new Absensi();
                $absensi->data_karyawan_id = $datakaryawan->id_data_karyawan;
                $absensi->tanggal = $today;
                $absensi->jam_masuk = $now;
                $absensi->status_absensi = 'Masuk';
                $absensi->save();
            }

            Alert::success('Berhasil Absen', 'Anda berhasil absen untuk hari ini, cek absensi anda di sebelah kanan halaman ini!');
            return redirect()->route('daftarabsensi.absensi');
        }

        return redirect()->back()->withErrors(['login' => 'Data login yang masukkan tidak valid, cek email / username dan password yang anda masukkan.']);

    }

    // endpoint untuk mendapatkan absensi hari ini
    public function getAbsensiHariIni(Request $request)
    {
        // Mengatur lokal Carbon ke bahasa Indonesia
        Carbon::setLocale('id');

        // Mendapatkan tanggal hari ini menggunakan Carbon
        $hariini = Carbon::today()->toDateString();

        // Query dengan kondisi tanggal hari ini
        $absensi = Absensi::with('dataKaryawan')
            ->select('absensi.*', 'data_karyawan.nama as nama_karyawan')
            ->join('data_karyawan', 'absensi.data_karyawan_id', '=', 'data_karyawan.id_data_karyawan')
            ->whereDate('absensi.tanggal', $hariini);

        if ($request->ajax()) {
            // Jika data kosong, pastikan mengembalikan format JSON yang benar
            if ($absensi->count() <= 0) {
                return response()->json([
                    'draw' => intval($request->input('draw')),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                ]);
            }

            return datatables()->of($absensi)
                ->addIndexColumn()
                ->toJson();
        }
    }

    public function logoutAbsensi(Request $request)
    {
        $request->session()->forget('master_authenticated');
        return redirect()->route('daftarabsensi.index');
    }
    // end function for absensi features
}
