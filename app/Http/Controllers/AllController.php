<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\DataKaryawan;
use App\Models\Gaji;
use App\Models\User;
use Auth;

class AllController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();

        $user = User::find($userId);

        // Mendapatkan data karyawan berdasarkan user_id
        $datakaryawan = DataKaryawan::where('user_id', $user->id_user)->first();

        if ($datakaryawan) {
            // Menghitung total gaji terbayar untuk satu karyawan
            $gajiperkaryawan = Gaji::where('status_gaji', 'Terbayar')
                ->where('data_karyawan_id', $datakaryawan->id_data_karyawan)
                ->sum('total_gaji');
            // Hitung total cuti yang diajukan oleh karyawan yang sedang login
            $pengajuancutiperkaryawan = Cuti::where('data_karyawan_id', $datakaryawan->id_data_karyawan)->count();
            $absensimasukperkaryawan = Absensi::where('status_absensi', 'Masuk')->where('data_karyawan_id', $datakaryawan->id_data_karyawan)->count();
        } else {
            // Jika data karyawan tidak ditemukan, set total gaji, pengajuan cuti, dan absensi menjadi 0
            $gajiperkaryawan = 0;
            $pengajuancutiperkaryawan = 0;
            $absensimasukperkaryawan = 0;
        }

        $totaldatakaryawan = DataKaryawan::count(); // cari jumlah data karyawan yang ada

        $totalcuti = Cuti::count(); // total jumlah cuti diajukan di tabel cuti

        $jumlahgajiterbayar = Gaji::where('status_gaji', 'Terbayar')->sum('total_gaji'); //hitung semua total gaji terbayar

        return view('index', compact('totaldatakaryawan', 'totalcuti', 'jumlahgajiterbayar', 'gajiperkaryawan', 'pengajuancutiperkaryawan', 'absensimasukperkaryawan'));
    }

    public function panduan()
    {
        return view('guide');
    }
}
