<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
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

    // Enhanced notification system methods

    /**
     * Create a notification for specific user(s)
     */
    public static function createNotification($userIds, $message, $type = 'info')
    {
        if (!is_array($userIds)) {
            $userIds = [$userIds];
        }

        $notifications = [];

        foreach ($userIds as $userId) {
            $notifications[] = [
                'pesan' => $message,
                'status_notifikasi' => 'Belum Dibaca',
                'jam' => now()->format('H:i:s'),
                'tanggal' => now()->format('Y-m-d'),
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Notifikasi::insert($notifications);

        return count($notifications);
    }

    /**
     * Create notification for leave request status change
     */
    public static function createLeaveNotification($employeeUserId, $status, $employeeName, $startDate, $endDate)
    {
        $statusMessages = [
            'Disetujui' => "Pengajuan cuti Anda dari {$startDate} hingga {$endDate} telah disetujui.",
            'Ditolak' => "Pengajuan cuti Anda dari {$startDate} hingga {$endDate} telah ditolak.",
            'Pending' => "Pengajuan cuti Anda dari {$startDate} hingga {$endDate} sedang ditinjau."
        ];

        $message = $statusMessages[$status] ?? "Status pengajuan cuti Anda telah diperbarui menjadi {$status}.";

        return self::createNotification($employeeUserId, $message);
    }

    /**
     * Create notification for payroll status change
     */
    public static function createPayrollNotification($employeeUserId, $status, $amount)
    {
        $formattedAmount = 'Rp ' . number_format($amount, 0, ',', '.');

        $statusMessages = [
            'Terbayar' => "Gaji Anda sebesar {$formattedAmount} telah dibayarkan.",
            'Diproses' => "Gaji Anda sebesar {$formattedAmount} sedang diproses.",
            'Belum Dibayar' => "Slip gaji Anda sebesar {$formattedAmount} telah tersedia."
        ];

        $message = $statusMessages[$status] ?? "Status pembayaran gaji Anda telah diperbarui.";

        return self::createNotification($employeeUserId, $message);
    }

    /**
     * Create system announcement for all users or specific roles
     */
    public static function createSystemAnnouncement($message, $targetRole = 'all')
    {
        $query = \App\Models\User::query();

        if ($targetRole !== 'all') {
            $query->whereHas('roles', function($q) use ($targetRole) {
                $q->where('name', $targetRole);
            });
        }

        $userIds = $query->pluck('id_user')->toArray();

        return self::createNotification($userIds, $message);
    }

    /**
     * Create notification for admin about new leave requests
     */
    public static function createAdminLeaveAlert($employeeName, $startDate, $endDate, $reason)
    {
        $message = "Pengajuan cuti baru dari {$employeeName} ({$startDate} - {$endDate}). Alasan: {$reason}";

        // Get all admin user IDs
        $adminUserIds = \App\Models\User::whereHas('roles', function($q) {
            $q->where('name', 'Administrator');
        })->pluck('id_user')->toArray();

        return self::createNotification($adminUserIds, $message);
    }

    /**
     * Get recent notifications for API
     */
    public function getRecentNotifications()
    {
        $userId = auth()->id();

        $notifications = Notifikasi::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($notification) {
                return [
                    'id' => $notification->id_notifikasi,
                    'message' => $notification->pesan,
                    'status' => $notification->status_notifikasi,
                    'time' => $notification->created_at->diffForHumans(),
                    'date' => $notification->tanggal,
                    'is_read' => $notification->status_notifikasi === 'Dibaca'
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'unread_count' => $notifications->where('is_read', false)->count()
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $userId = auth()->id();

        $notification = Notifikasi::where('id_notifikasi', $id)
            ->where('user_id', $userId)
            ->first();

        if ($notification && $notification->status_notifikasi === 'Belum Dibaca') {
            $notification->status_notifikasi = 'Dibaca';
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notification not found or already read'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $userId = auth()->id();

        $updated = Notifikasi::where('user_id', $userId)
            ->where('status_notifikasi', 'Belum Dibaca')
            ->update(['status_notifikasi' => 'Dibaca']);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
            'updated_count' => $updated
        ]);
    }
}
