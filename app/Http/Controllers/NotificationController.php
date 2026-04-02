<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
public function read($id) {
    $notif = Notification::findOrFail($id);
    $notif->update(['is_read' => true]);
    return redirect($notif->url);
}
}
