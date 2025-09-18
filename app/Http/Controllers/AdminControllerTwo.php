<?php

namespace App\Http\Controllers;

use Alert;
use App\Exports\DataRekrutmenExport;
use App\Models\DataKaryawan;
use App\Models\Rekrutmen;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Validator;

// controller for rekrutmen
class AdminControllerTwo extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datarekrutmen = Rekrutmen::all();

        confirmDelete();

        return view('admin.rekrutmen.index', compact('datarekrutmen'));
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
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'nomorTelepon' => 'required|regex:/^\+?[0-9\-\(\)\s]+$/',
            'keahlian' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 1);
        }

        // ELOQUENT DATA REKRUTMEN
        $datarekrutmen = new Rekrutmen;
        $datarekrutmen->nama = $request->nama;
        $datarekrutmen->email = $request->email;
        $datarekrutmen->alamat = $request->alamat;
        $datarekrutmen->nomor_telepon = $request->nomorTelepon;
        $datarekrutmen->status_rekrutmen = 'Proses';
        $datarekrutmen->keahlian = $request->keahlian;
        $datarekrutmen->catatan = $request->catatan;
        $datarekrutmen->save();

        Alert::success('Berhasil ditambahkan', 'Data rekrutmen berhasil ditambahkan!');

        return redirect()->route('rekrutmen.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datarekrutmen = Rekrutmen::find($id);

        return view('admin.rekrutmen.index', compact('datarekrutmen'));
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
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'nomorTelepon' => 'required|regex:/^\+?[0-9\-\(\)\s]+$/',
            'keahlian' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_in_modal', 2);
        }

        // Inisiasi pemanggilan data dari database ke variabel
        $datarekrutmen = Rekrutmen::find($id);

        // ELOQUENT DATA REKRUTMEN
        $datarekrutmen->nama = $request->nama;
        $datarekrutmen->email = $request->email;
        $datarekrutmen->alamat = $request->alamat;
        $datarekrutmen->nomor_telepon = $request->nomorTelepon;
        $datarekrutmen->keahlian = $request->keahlian;
        $datarekrutmen->catatan = $request->catatan;
        $datarekrutmen->save();

        Alert::success('Berhasil Disunting', 'Data rekrutmen berhasil disunting!');

        return redirect()->route('rekrutmen.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $rekrutmen = Rekrutmen::find($id);
        $datakaryawancount = DataKaryawan::where('rekrutmen_id', $rekrutmen->id_rekrutmen)->count();

        if (empty($rekrutmen)) {
            return redirect()->back();
        } 
        
        if ($datakaryawancount > 0) {
            Alert::error('Data Gagal Dihapus', 'Data rekrutmen gagal dihapus, terdapat data karyawan yang masih tertaut, ubah status rekrutmen menjadi ditolak terlebih dahulu!');
            return redirect()->route('rekrutmen.index');
        }

        $rekrutmen->delete();

        Alert::success('Data Berhasil Dihapus', 'Data rekrutmen berhasil dihapus!');

        return redirect()->route('rekrutmen.index');

    }

    public function getData(Request $request)
    {
        $datarekrutmen = Rekrutmen::query();
        if ($request->ajax()) {
            return datatables()->of($datarekrutmen)
                ->addIndexColumn()
                ->addColumn('actions', function ($satudatarekrutmen) {
                    return view('admin.rekrutmen.actions', compact('satudatarekrutmen'));
                })
                ->toJson();
        }
    }

    public function statusRekrutmenQuery(Request $request, String $id)
    {
        // Digunakan untuk mendelete user data yang nantinya akan mendelete data karyawan juga jika status rekrutmen menjadi proses atau ditolak dan terdapat data karyawan dengan rekrutmen_id yang sesuai id_rekrutmen pada data rekrutmen yang sedang diquery saat ini
        function deleteUserData($id)
        {
            // Jika status_rekrutmen diubah menjadi "Ditolak" atau "Proses", hapus data karyawan terkait
            $datakaryawan = DataKaryawan::where('rekrutmen_id', $id)->first();
            $user_id = $datakaryawan->user_id; // mencari nilai user id dari record data karyawan
            // Hapus data user terkait
            User::where('id_user', $user_id)->delete();
        }

        // Inisiasi pemanggilan data dari database ke variabel
        $datarekrutmen = Rekrutmen::find($id);

        // request->button_value merupakan input hidden yang ada pada form input yang menyimpan data value dari tombol diterima, ditolak, dan proses
        $button_value = $request->button_value;

        // Eloquent kolom status_rekrutmen
        $datarekrutmen->status_rekrutmen = $button_value;
        $datarekrutmen->save();

        // Cek jika tidak ada karyawan dengan rekrutmen_id yang sesuai dengan id_rekrutmen pada data di tabel rekrutmen
        $existingEmployee = DataKaryawan::where('rekrutmen_id', $id)->first();

        if ($button_value == 'Diterima') {
            if ($existingEmployee) {
                Alert::success('Kandidat telah diterima', 'Kandidat sudah diterima sebelumnya dan telah menjadi karyawan!');
            } else {
                // ELOQUENT DATA AKUN
                $user = new User;
                $user->username = strtok($datarekrutmen->email, '@'); // Ambil bagian sebelum '@'
                $user->email = $datarekrutmen->email;
                $user->password = bcrypt('password');
                $user->role = 'Employee';
                $user->save();

                // ELOQUENT DATA KARYAWAN
                $datakaryawan = new DataKaryawan;
                $datakaryawan->nama = $datarekrutmen->nama;
                $datakaryawan->alamat = $datarekrutmen->alamat;
                $datakaryawan->nomor_telepon = $datarekrutmen->nomor_telepon;
                $datakaryawan->status_karyawan = 'Karyawan Kontrak';
                $datakaryawan->keahlian = $datarekrutmen->keahlian;
                $datakaryawan->jabatan = 'Karyawan';
                $datakaryawan->user_id = $user->id_user;
                $datakaryawan->rekrutmen_id = $id;

                $datakaryawan->save();

                Alert::success('Kandidat telah diterima', 'Kandidat berhasil diterima dan menjadi karyawan!');
            }
        } else if ($button_value == 'Ditolak') {
            if ($existingEmployee) {
                deleteUserData($id);
            }
            Alert::error('Kandidat telah ditolak', 'Kandidat berhasil ditolak, gagal menjadi karyawan!');
        } else {
            if ($existingEmployee) {
                deleteUserData($id);
            }
            Alert::info('Kandidat dalam tahap proses', 'Kandidat masih dalam tahap proses perekrutan lebih lanjut!');
        }

        return redirect()->route('rekrutmen.index');
    }

    public function exportExcel()
    {
        return Excel::download(new DataRekrutmenExport, 'Data Rekrutmen.xlsx');
    }

    public function exportPDF()
    {
        $datarekrutmen = Rekrutmen::all();
        $pdf = PDF::loadView('admin.rekrutmen.export_pdf', compact('datarekrutmen'));
        return $pdf->download('Data Rekrutmen.pdf');
    }
}
