<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\DataKaryawan;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil pengguna yang sedang login pada tabel users
        $user = Auth::user();

        // Mengambil data karyawan yang terkait
        $datakaryawan = $user->datakaryawan;

        return view('profile.index', compact('user', 'datakaryawan'));
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
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'nomorTelepon' => 'required|regex:/^\+?[0-9\-\(\)\s]+$/',
            'keahlian' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:6|confirmed', // Validasi untuk password
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ELOQUENT DATA AKUN
        $user = User::find($request->idUser);
        $user->email = $request->email;
        if ($request->password !== null) {
            $user->password = bcrypt($request->password);

        }

        $user->save();

        // ELOQUENT DATA KARYAWAN
        $datakaryawan = DataKaryawan::find($request->idDataKaryawan);
        $datakaryawan->nama = $request->nama;
        $datakaryawan->alamat = $request->alamat;
        $datakaryawan->nomor_telepon = $request->nomorTelepon;
        $datakaryawan->keahlian = $request->keahlian;
        $datakaryawan->save();

        Alert::success('Berhasil disunting', 'Data pada profil berhasil disunting!');

        return redirect()->route('profil.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // menggunakan sunting ketimbang edit karena untuk menghilangkan url berbentuk parameter get ketika menggunakan default route edit, sehingga menggunakan fungsi dan route baru yaitu sunting.
    
    public function sunting()
    {
        // Mengambil data pengguna yang sedang login pada tabel users
        $user = Auth::user();

        // Mengambil data karyawan yang terkait
        $datakaryawan = $user->datakaryawan;

        return view('profile.edit', compact('user', 'datakaryawan'));
    }
}
