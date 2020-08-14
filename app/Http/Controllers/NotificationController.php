<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Cookie;

class NotificationController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $notification_id
     * @return \Illuminate\Http\Response
     */
    public function __invoke($notification_id)
    {
        $notification = Auth::user()
        ->unreadNotifications
        ->where('id', $notification_id)
        ->first();

        abort_if( ! $notification, 404);

        $redirect = $notification->data['url'];

        $notification->markAsRead();

        unset($_COOKIE['has_notification_cookies_set']);

        return redirect($redirect);
    }
}
