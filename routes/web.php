<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminControllerFive;
use App\Http\Controllers\AdminControllerFour;
use App\Http\Controllers\AdminControllerOne;
use App\Http\Controllers\AdminControllerThree;
use App\Http\Controllers\AdminControllerTwo;
use App\Http\Controllers\AllController;
use App\Http\Controllers\EmployeeControllerOne;
use App\Http\Controllers\EmployeeControllerThree;
use App\Http\Controllers\EmployeeControllerTwo;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

// route untuk mengakses semua rute terkait autentikasi
Auth::routes([
    'reset' => true, // Enable reset password routes
    'verify' => false, // Disable email verification
]);

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'authenticate'])->name('daftarabsensi.loginAbsensi');

// redirect rute root ke dashboard
Route::redirect('/', 'dashboard');

// grouping untuk route yang membutuhkan autentikasi
Route::middleware(['auth', 'no.cache'])->group(function () {

    // Grouping Routes untuk ADMINISTRATOR
    Route::middleware(['role:Administrator'])->group(function () {

        // route halaman data karyawan
        Route::resource('datakaryawan', AdminControllerOne::class);
        Route::get('getDataKaryawan', [AdminControllerOne::class, 'getData'])->name('datakaryawan.getData');
        Route::get('exportExcelDataKaryawan', [AdminControllerOne::class, 'exportExcel'])->name('datakaryawan.exportExcel');
        Route::get('exportPDFDataKaryawan', [AdminControllerOne::class, 'exportPDF'])->name('datakaryawan.exportPDF');

        // route halaman rekrutmen
        Route::resource('rekrutmen', AdminControllerTwo::class);
        Route::get('getRekrutmen', [AdminControllerTwo::class, 'getData'])->name('rekrutmen.getData');
        Route::post('statusRekrutmenQuery/{id}', [AdminControllerTwo::class, 'statusRekrutmenQuery'])->name('rekrutmen.statusRekrutmenQuery');
        Route::get('exportExcelDataRekrutmen', [AdminControllerTwo::class, 'exportExcel'])->name('rekrutmen.exportExcel');
        Route::get('exportPDFDataRekrutmen', [AdminControllerTwo::class, 'exportPDF'])->name('rekrutmen.exportPDF');

        // route halaman daftar absensi untuk admin
        Route::resource('daftarabsensi', AdminControllerThree::class);
        Route::get('getDaftarAbsensi', [AdminControllerThree::class, 'getData'])->name('daftarabsensi.getData');
        Route::post('generateabsensi', [AdminControllerThree::class, 'generateAbsenceData'])->name('daftarabsensi.generateAbsenceData');
        Route::post('ExportPDFDaftarAbsensi', [AdminControllerThree::class, 'exportPDF'])->name('daftarabsensi.exportPDF');
        Route::post('exportExcelDaftarAbsensi', [AdminControllerThree::class, 'exportExcel'])->name('daftarabsensi.exportExcel');

        // route halaman persetujuan cuti
        Route::resource('persetujuancuti', AdminControllerFour::class);
        Route::get('getPersetujuanCuti', [AdminControllerFour::class, 'getData'])->name('persetujuancuti.getData');
        Route::get('exportExcelDataPersetujuanCuti', [AdminControllerFour::class, 'exportExcel'])->name('persetujuancuti.exportExcel');
        Route::get('exportPDFDataPersetujuanCuti', [AdminControllerFour::class, 'exportPDF'])->name('persetujuancuti.exportPDF');
        Route::post('statusCutiQuery/{id}', [AdminControllerFour::class, 'statusCutiQuery'])->name('persetujuancuti.statusCutiQuery');

        // route halaman penggajian
        Route::resource('penggajian', AdminControllerFive::class);
        Route::get('getDataKaryawanPenggajian', [AdminControllerFive::class, 'getData'])->name('penggajian.getData');
        Route::get('getRiwayatGajiPerKaryawan', [AdminControllerFive::class, 'getDataPerEmployee'])->name('penggajian.getDataPerEmployee');
        Route::post('exportPDFPenggajian', [AdminControllerFive::class, 'exportPDF'])->name('penggajian.exportPDF');
        Route::post('exportExcelPenggajian', [AdminControllerFive::class, 'exportExcel'])->name('penggajian.exportExcel');
        Route::post('storeKomponenGaji', [AdminControllerFive::class, 'storeKomponenGaji'])->name('penggajian.storeKomponenGaji');
        Route::post('updateKomponenGaji', [AdminControllerFive::class, 'updateKomponenGaji'])->name('penggajian.updateKomponenGaji');
        Route::get('kalkulasiPotonganAbsensi', [AdminControllerFive::class, 'kalkulasiPotonganAbsensi'])->name('penggajian.kalkulasiPotonganAbsensi'); // return berupa json kalkulasi potongan absensi
        Route::post('statusGajiQuery/{id}', [AdminControllerFive::class, 'statusGajiQuery'])->name('penggajian.statusGajiQuery');

    });

    // RUTE UNTUK KARYAWAN / EMPLOYEE

    // route pengajuan cuti
    Route::resource('pengajuancuti', EmployeeControllerOne::class);
    Route::get('getPengajuanCuti', [EmployeeControllerOne::class, 'getData'])->name('pengajuancuti.getData');

    // route riwayat gaji
    Route::resource('riwayatgaji', EmployeeControllerTwo::class);
    Route::get('getRiwayatGaji', [EmployeeControllerTwo::class, 'getData'])->name('riwayatgaji.getData');
    Route::post('exportPDFRiwayatGaji', [EmployeeControllerTwo::class, 'exportPDF'])->name('riwayatgaji.exportPDF');

    // route riwayat absensi untuk karyawan
    Route::get('riwayatabsensi', [EmployeeControllerThree::class, 'index'])->name('riwayatabsensi.index');
    Route::get('getRiwayatAbsensi', [EmployeeControllerThree::class, 'getRiwayatAbsensi'])->name('riwayatabsensi.getRiwayatAbsensi');

    // ROUTE UNTUK KARYAWAN DAN ADMIN
    // route profile
     Route::get('/profil/sunting', [ProfileController::class, 'sunting'])->name('profil.sunting');
    Route::resource('profil', ProfileController::class);
   
    // route panduan penggunaan aplikasi
    Route::get('panduan', [AllController::class, 'panduan'])->name('panduan');
    // route untuk menampilkan dashboard dan juga get data untuk halaman dashboard yaitu absensi hari ini
    Route::get('dashboard', [AllController::class, 'dashboard'])->name('dashboard');
    // route untuk notifikasi
    Route::resource('notifikasi', NotifikasiController::class);
    Route::get('/getNotifikasiCount', [NotifikasiController::class, 'count']);
});

// route untuk login agar dapat mengakses route yang ada di dalam middleware master
Route::get('loginabsensi', [AdminControllerThree::class, 'showLoginAbsensiForm'])->name('daftarabsensi.loginAbsensi');
Route::post('loginabsensi', [AdminControllerThree::class, 'authenticationAbsensiForm'])->name('daftarabsensi.loginAbsensi');
Route::post('logoutabsensi', [AdminControllerThree::class, 'logoutAbsensi'])->name('daftarabsensi.logoutAbsensi');

// route yang mengambil middleware master untuk memastikan baha yang memasuki route ini telah di set session login sebagai master
Route::middleware(['master', 'no.cache'])->group(function () {
    // Route untuk absensi semua karyawan dengan memasukkan sandi master password dari aplikasi ini
    Route::get('absensi', [AdminControllerThree::class, 'absensi'])->name('daftarabsensi.absensi');
    Route::post('absensi', [AdminControllerThree::class, 'catatAbsensi'])->name('daftarabsensi.catatAbsensi');
    Route::get('getAbsensiHariIni', [AdminControllerThree::class, 'getAbsensiHariIni'])->name('getAbsensiHariIni');
});

// Rute untuk kontroller semua, menangani manajemen aplikasi secara umum bagi semua pengguna, nama kontroller = AllController
