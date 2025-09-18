<?php

namespace App\Http\Controllers;

use App\Models\DataKaryawan;
use App\Models\Gaji;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

// kontroller riwayat gaji
class EmployeeControllerTwo extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('employee.riwayatgaji.index');
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
        //
    }

    public function getData(Request $request)
    {
        // Mendapatkan ID pengguna yang sedang login dari session
        $userId = Auth::id();

        $dataKaryawanId = DataKaryawan::where('user_id', $userId)->pluck('id_data_karyawan')->first();

        // Mencari data persetujuan gaji berdasarkan ID pengguna dan status_gaji Terbayar
        $gaji = Gaji::where('data_karyawan_id', $dataKaryawanId)
            ->where('status_gaji', 'Terbayar');

        if ($request->ajax()) {
            // Jika data kosong, pastikan mengembalikan format JSON yang benar
            if ($gaji->count() <= 0) {
                return response()->json([
                    'draw' => intval($request->input('draw')),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                ]);
            }

            return datatables()->of($gaji)
                ->addIndexColumn()
                ->addColumn('actions', function ($gajisatukaryawan) {
                    return view('employee.riwayatgaji.actions', compact('gajisatukaryawan'));
                })
                ->toJson();
        }

        return response()->json([
            'message' => 'This request is not supported.',
        ], 400); // return a 400 Bad Request if it's not an ajax request
    }

    public function exportPDF(Request $request)
    {
        $id = $request->id_gaji;
        $gaji = Gaji::with('dataKaryawan')->find($id);
        $tahun_bulan_parse = Carbon::parse($gaji->tahun_bulan)->locale('id')->translatedFormat('F Y');

        return view('employee.riwayatgaji.export_pdf', compact('gaji', 'tahun_bulan_parse'));
    }
}
