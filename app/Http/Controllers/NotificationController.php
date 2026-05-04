<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    public function markAsRead(string $notification): RedirectResponse
    {
        $notificationModel = auth()->user()
            ->notifications()
            ->where('id', $notification)
            ->firstOrFail();

        $notificationModel->markAsRead();

        $url = $notificationModel->data['url'] ?? route('dashboard');

        return redirect($url);
    }
}