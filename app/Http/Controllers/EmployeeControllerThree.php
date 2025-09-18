<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Auth;
use Illuminate\Http\Request;

// kontroller riwayat absensi
class EmployeeControllerThree extends Controller
{
    public function index()
    {
        return view('employee.riwayatabsensi.index');
    }

    public function getRiwayatAbsensi(Request $request)
    {
        $user = Auth::user();
        $datariwayatabsensi = Absensi::whereHas('dataKaryawan', function ($query) use ($user) {
            $query->where('user_id', $user->id_user); // Filter berdasarkan user_id dari data karyawan
        });

        if ($request->ajax()) {
            return datatables()->of($datariwayatabsensi)
                ->addIndexColumn()
                ->toJson();
        }
    }
}
