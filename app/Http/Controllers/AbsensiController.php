<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\DataKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'Administrator';

        if ($isAdmin) {
            // Admin view - show all attendance records
            return view('absensi.index', compact('isAdmin'));
        } else {
            // Employee view - show personal attendance
            $dataKaryawan = DataKaryawan::where('user_id', $user->id_user)->first();
            return view('absensi.index', compact('isAdmin', 'dataKaryawan'));
        }
    }

    /**
     * Get data for DataTables
     */
    public function getData(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'Administrator';

        if ($isAdmin) {
            // Admin can see all attendance records
            $query = Absensi::with('dataKaryawan')
                ->select(['id_absensi', 'tanggal', 'jam_masuk', 'status_absensi', 'keterangan', 'data_karyawan_id', 'created_at']);
        } else {
            // Employee can only see their own records
            $dataKaryawan = DataKaryawan::where('user_id', $user->id_user)->first();
            if (!$dataKaryawan) {
                return response()->json(['data' => []]);
            }

            $query = Absensi::with('dataKaryawan')
                ->where('data_karyawan_id', $dataKaryawan->id_data_karyawan)
                ->select(['id_absensi', 'tanggal', 'jam_masuk', 'status_absensi', 'keterangan', 'data_karyawan_id', 'created_at']);
        }

        return DataTables::of($query)
            ->addColumn('nama_karyawan', function ($row) {
                return $row->dataKaryawan->nama ?? 'N/A';
            })
            ->addColumn('tanggal_formatted', function ($row) {
                return Carbon::parse($row->tanggal)->format('d M Y');
            })
            ->addColumn('status_badge', function ($row) {
                $badgeClass = match ($row->status_absensi) {
                    'Masuk' => 'bg-success',
                    'Izin' => 'bg-warning',
                    'Sakit' => 'bg-info',
                    'Alpha' => 'bg-danger',
                    default => 'bg-secondary'
                };
                return '<span class="badge ' . $badgeClass . '">' . $row->status_absensi . '</span>';
            })
            ->addColumn('action', function ($row) use ($isAdmin) {
                $actions = '';
                if ($isAdmin) {
                    $actions .= '<a href="' . route('absensi.edit', $row->id_absensi) . '" class="btn btn-sm btn-warning me-1">
                        <i class="bi bi-pencil"></i> Edit
                    </a>';
                    $actions .= '<form method="POST" action="' . route('absensi.destroy', $row->id_absensi) . '" class="d-inline">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin ingin menghapus?\')">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>';
                } else {
                    $actions = '<span class="text-muted">-</span>';
                }
                return $actions;
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'Administrator';

        if ($isAdmin) {
            $employees = DataKaryawan::where('status_karyawan', 'Aktif')->get();
            return view('absensi.create', compact('employees', 'isAdmin'));
        } else {
            $dataKaryawan = DataKaryawan::where('user_id', $user->id_user)->first();
            return view('absensi.create', compact('dataKaryawan', 'isAdmin'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'Administrator';

        $rules = [
            'tanggal' => 'required|date',
            'jam_masuk' => 'required|date_format:H:i',
            'status_absensi' => 'required|in:Masuk,Izin,Sakit,Alpha',
            'keterangan' => 'nullable|string|max:500',
        ];

        if ($isAdmin) {
            $rules['data_karyawan_id'] = 'required|exists:data_karyawan,id_data_karyawan';
        }

        $validatedData = $request->validate($rules);

        if (!$isAdmin) {
            $dataKaryawan = DataKaryawan::where('user_id', $user->id_user)->first();
            if (!$dataKaryawan) {
                return redirect()->back()->with('error', 'Data karyawan tidak ditemukan');
            }
            $validatedData['data_karyawan_id'] = $dataKaryawan->id_data_karyawan;
        }

        // Check if attendance for this employee on this date already exists
        $existingAbsensi = Absensi::where('data_karyawan_id', $validatedData['data_karyawan_id'])
            ->where('tanggal', $validatedData['tanggal'])
            ->first();

        if ($existingAbsensi) {
            return redirect()->back()->with('error', 'Absensi untuk tanggal ini sudah ada');
        }

        Absensi::create($validatedData);

        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $absensi = Absensi::with('dataKaryawan')->findOrFail($id);
        return view('absensi.show', compact('absensi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'Administrator';

        if (!$isAdmin) {
            return redirect()->route('absensi.index')->with('error', 'Anda tidak memiliki akses untuk mengedit absensi');
        }

        $absensi = Absensi::with('dataKaryawan')->findOrFail($id);
        $employees = DataKaryawan::where('status_karyawan', 'Aktif')->get();

        return view('absensi.edit', compact('absensi', 'employees', 'isAdmin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'Administrator';

        if (!$isAdmin) {
            return redirect()->route('absensi.index')->with('error', 'Anda tidak memiliki akses untuk mengedit absensi');
        }

        $absensi = Absensi::findOrFail($id);

        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jam_masuk' => 'required|date_format:H:i',
            'status_absensi' => 'required|in:Masuk,Izin,Sakit,Alpha',
            'keterangan' => 'nullable|string|max:500',
            'data_karyawan_id' => 'required|exists:data_karyawan,id_data_karyawan',
        ]);

        // Check if attendance for this employee on this date already exists (excluding current record)
        $existingAbsensi = Absensi::where('data_karyawan_id', $validatedData['data_karyawan_id'])
            ->where('tanggal', $validatedData['tanggal'])
            ->where('id_absensi', '!=', $id)
            ->first();

        if ($existingAbsensi) {
            return redirect()->back()->with('error', 'Absensi untuk tanggal ini sudah ada');
        }

        $absensi->update($validatedData);

        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'Administrator';

        if (!$isAdmin) {
            return redirect()->route('absensi.index')->with('error', 'Anda tidak memiliki akses untuk menghapus absensi');
        }

        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil dihapus');
    }
}
