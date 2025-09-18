<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ExperimentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function experiment()
    {
        $id = 3;
        $gaji = Gaji::with('dataKaryawan')->find($id);
        return view('employee.riwayatgaji.export_pdf', compact('gaji'));
    }

    public function sendTestEmail()
    {
        $details = [
            'subject' => 'Test Email',
            'body' => 'This is a test email',
        ];

        Mail::raw($details['body'], function ($message) use ($details) {
            $message->to('briliantfikri@gmail.com')
                ->subject($details['subject']);
        });

        return 'Email sent successfully';
    }
}
