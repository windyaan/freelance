<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // ambil semua notifikasi user login
public function index()
{
    return Notification::where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();
}

// tandai notifikasi sudah dibaca
public function markAsRead($id)
{
    $notification = Notification::where('user_id', Auth::id())
        ->findOrFail($id);

    $notification->update(['is_read' => true]);

    return response()->json(['success' => true]);
}
}
