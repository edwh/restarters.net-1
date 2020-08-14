<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class ClearAuthenticatedCookies
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        if ($user = $event->user) {
            $user->logoutOfDiscourse();
        }
    }
}
