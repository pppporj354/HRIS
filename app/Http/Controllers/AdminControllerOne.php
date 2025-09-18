<?php

namespace App\Http\Controllers;

use Alert;
use App\Exports\DataKaryawanExport;
use App\Models\DataKaryawan;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Validator;

// controller for datakaryawan
class AdminControllerOne extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // use UsersDataTable $dataTable inside parameter index to use datatable html builder
    public function index()
    {
        $datakaryawan = DataKaryawan::with(['rekrutmen', 'user']);
        $datarekrutmen = session('datarekrutmen', null); // Ambil datarekrutmen dari session, default null

        confirmDelete();

        return view('admin.datakaryawan.index', compact('datakaryawan', 'datarekrutmen'));
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
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'nomorTelepon' => 'required|regex:/^\+?[0-9\-\(\)\s]+$/',
            'statusKaryawan' => 'required',
            'keahlian' => 'required',
            'jabatan' => 'required',
            'email' => 'required|email',
            'username' => 'required|unique:users,username', // Validasi untuk username
            'password' => 'required|min:6|confirmed', // Validasi untuk password
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 1);
        }

        // ELOQUENT DATA AKUN
        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();

        // ELOQUENT DATA KARYAWAN
        $datakaryawan = new DataKaryawan;
        $datakaryawan->nama = $request->nama;
        $datakaryawan->alamat = $request->alamat;
        $datakaryawan->nomor_telepon = $request->nomorTelepon;
        $datakaryawan->status_karyawan = $request->statusKaryawan;
        $datakaryawan->keahlian = $request->keahlian;
        $datakaryawan->jabatan = $request->jabatan;
        $datakaryawan->user_id = $user->id_user;
        if ($request->rekrutmenId !== null) {
            $datakaryawan->rekrutmen_id = $request->rekrutmenId;
        }
        $datakaryawan->save();

        Alert::success('Berhasil Ditambahkan', 'Data karyawan berhasil ditambahkan!');

        return redirect()->route('datakaryawan.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // ELOQUENT
        $datakaryawan = DataKaryawan::with(['rekrutmen', 'user'])->find($id);
        return view('admin.datakaryawan.index', compact('datakaryawan'));
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
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka',
            'regex' => 'Isikan dengan angka 0-9 atau tanda seperti "+", "-", atau spasi',
        ];
        $validator = Validator::make($request->all(), [
            'namaEdit' => 'required',
            'alamatEdit' => 'required',
            'nomorTeleponEdit' => 'required|regex:/^\+?[0-9\-\(\)\s]+$/',
            'statusKaryawanEdit' => 'required',
            'keahlianEdit' => 'required',
            'jabatanEdit' => 'required',
            'emailEdit' => 'required|email',
            'passwordEdit' => 'nullable|min:6|confirmed',
            'roleEdit' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 2);
        }

        // Inisiasi pemanggilan data dari database ke variabel
        $datakaryawan = DataKaryawan::find($id);
        $user = User::find($datakaryawan->user_id);

        // ELOQUENT DATA AKUN
        $user->email = $request->emailEdit;
        if ($request->password !== null) {
            $user->password = bcrypt($request->passwordEdit);
        }
        $user->role = $request->roleEdit;
        $user->save();

        // ELOQUENT DATA KARYAWAN
        $datakaryawan->nama = $request->namaEdit;
        $datakaryawan->alamat = $request->alamatEdit;
        $datakaryawan->nomor_telepon = $request->nomorTeleponEdit;
        $datakaryawan->status_karyawan = $request->statusKaryawanEdit;
        $datakaryawan->keahlian = $request->keahlianEdit;
        $datakaryawan->jabatan = $request->jabatanEdit;
        $datakaryawan->save();

        Alert::success('Berhasil Disunting', 'Data karyawan berhasil disunting!');

        return redirect()->route('datakaryawan.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // ELOQUENT
        $userId = DataKaryawan::where('id_data_karyawan', $id)->pluck('user_id')->first();

        if (empty($userId)) {
            return redirect()->back();
        }

        $user = User::find($userId);

        if (empty($user)) {
            return redirect()->back();
        }

        $user->delete();

        Alert::success('Data Berhasil Dihapus', 'Data Karyawan telah berhasil dihapus!');

        return redirect()->route('datakaryawan.index');

    }

    public function getData(Request $request)
    {
        $datakaryawan = DataKaryawan::with(['rekrutmen', 'user']);

        if ($request->ajax()) {
            return datatables()->of($datakaryawan)
                ->addIndexColumn()
                ->addColumn('aksi', function ($satudatakaryawan) {
                    return view('admin.datakaryawan.actions', compact('satudatakaryawan'));
                })
                ->toJson();
        }
    }

    public function exportExcel()
    {
        return Excel::download(new DataKaryawanExport, 'Data Karyawan.xlsx');
    }

    public function exportPdf()
    {
        $datakaryawan = DataKaryawan::all();
        $pdf = PDF::loadView('admin.datakaryawan.export_pdf', compact('datakaryawan'));
        return $pdf->download('Data Karyawan.pdf');
    }
}
