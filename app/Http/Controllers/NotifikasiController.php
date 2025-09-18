<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Notifikasi;
use Auth;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan ID pengguna yang sedang login dari session
        $userId = Auth::id();

        confirmDelete();

        $notifikasi = Notifikasi::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        // Looping melalui setiap notifikasi
        foreach ($notifikasi as $notif) {
            // menambahkan kondisi agar tidak merubah semua sudah dibaca tetapi hanya notif yang belum dibaca diubah menjadi dibaca
            if ($notif->status_notifikasi == 'Belum Dibaca') {
                // Perbarui status_notifikasi menjadi 'Dibaca'
                $notif->status_notifikasi = 'Dibaca';
                // Simpan perubahan
                $notif->save();
            }

        }

        return view('adminandemployee.notifikasi.index', compact('notifikasi', 'userId'));
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
        $userId = Auth::id();

        if ($id != $userId) {
            return redirect()->route('notifikasi.index');
        }

        $notifikasi = Notifikasi::where('user_id', $userId)->delete();

        Alert::success('Berhasil Dibersihkan', 'Notifikasi berhasil dibersihkan!');

        return redirect()->route('notifikasi.index');
    }

    public function count()
    {
        $count = Notifikasi::where('user_id', auth()->id())
            ->where('status_notifikasi', 'Belum Dibaca')
            ->count();

        return response()->json(['count' => $count]);
    }
}
