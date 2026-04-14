<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Halaman semua notifikasi (admin & user)
     */
    public function index(Request $request)
    {
        $isAdmin = auth()->user()->role === 'admin';

        $baseQuery = $isAdmin
            ? Notification::whereNull('user_id')
            : Notification::where('user_id', auth()->id());

        $filterType   = $request->input('type', '');
        $filterStatus = $request->input('status', '');

// Di NotificationController@index, ubah query default-nya
$query = clone $baseQuery;

if ($filterType)
    $query->where('type', $filterType);

// Tambah ini — default hanya tampilkan yang belum dibaca
// kecuali user memilih filter "read" atau "semua"
if ($filterStatus === 'read')
    $query->where('is_read', true);
elseif ($filterStatus === 'unread' || $filterStatus === '')
    $query->where('is_read', false);  // ← default hanya unread
// kalau $filterStatus === 'all' → tidak filter apapun

        $notifications = $query->latest()->paginate(15)->withQueryString();

        $totalCount  = (clone $baseQuery)->count();
        $unreadCount = (clone $baseQuery)->where('is_read', false)->count();
        $readCount   = $totalCount - $unreadCount;

        return view('notifications.index', compact(
            'notifications',
            'totalCount',
            'unreadCount',
            'readCount',
            'filterType',
            'filterStatus'
        ));
    }

    /**
     * Tandai satu notifikasi sebagai dibaca lalu redirect
     */
    public function read($id)
    {
        try {
            $isAdmin = auth()->user()->role === 'admin';

            // Pastikan notifikasi milik yang berhak
            $query = $isAdmin
                ? Notification::whereNull('user_id')
                : Notification::where('user_id', auth()->id());

            $notification = $query->findOrFail($id);
            $notification->update(['is_read' => true]);

            return redirect($notification->url ?? ($isAdmin ? route('dashboard') : route('home')));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Notifikasi tidak ditemukan.');
        }
    }

    /**
     * Tandai semua notifikasi sebagai dibaca
     */
    public function readAll(Request $request)
    {
        try {
            $isAdmin = auth()->user()->role === 'admin';

            $updated = $isAdmin
                ? Notification::whereNull('user_id')->where('is_read', false)->update(['is_read' => true])
                : Notification::where('user_id', auth()->id())->where('is_read', false)->update(['is_read' => true]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "{$updated} notifikasi telah ditandai dibaca.",
                    'count'   => $updated,
                ]);
            }

            return redirect()->back()->with('success', 'Semua notifikasi telah ditandai dibaca.');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menandai notifikasi.');
        }
    }

    /**
     * Hapus satu notifikasi
     */
    public function destroy($id)
    {
        try {
            $isAdmin = auth()->user()->role === 'admin';

            $query = $isAdmin
                ? Notification::whereNull('user_id')
                : Notification::where('user_id', auth()->id());

            $notification = $query->findOrFail($id);
            $notification->delete();

            return redirect()->back()->with('success', 'Notifikasi dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Notifikasi tidak ditemukan.');
        }
    }

    /**
     * Hapus semua notifikasi yang sudah dibaca
     */
    public function destroyRead(Request $request)
    {
        try {
            $isAdmin = auth()->user()->role === 'admin';

            $deleted = $isAdmin
                ? Notification::whereNull('user_id')->where('is_read', true)->delete()
                : Notification::where('user_id', auth()->id())->where('is_read', true)->delete();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "{$deleted} notifikasi dihapus.",
                ]);
            }

            return redirect()->back()->with('success', "{$deleted} notifikasi yang sudah dibaca berhasil dihapus.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus notifikasi.');
        }
    }

    /**
     * Jumlah notifikasi belum dibaca (untuk AJAX polling)
     */
    public function getUnreadCount()
    {
        $isAdmin = auth()->user()->role === 'admin';

        $count = $isAdmin
            ? Notification::whereNull('user_id')->where('is_read', false)->count()
            : Notification::where('user_id', auth()->id())->where('is_read', false)->count();

        $stockAlert = $isAdmin
            ? Notification::whereNull('user_id')->where('type', 'stock')->where('is_read', false)->latest()->first()
            : null;

        return response()->json([
            'count'         => $count,
            'has_stock_alert' => (bool) $stockAlert,
            'stock_message' => $stockAlert?->message,
        ]);
    }
}