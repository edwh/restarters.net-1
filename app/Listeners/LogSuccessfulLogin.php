<?php

namespace App\Listeners;

use App\User;
use Carbon\Carbon;
use Cookie;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;

        $user->last_login_at = Carbon::now()->toDateTimeString();
        $user->number_of_logins += 1;

        // Sync user with Groups on Discourse
        if ( ! $user->groups->isEmpty()) {
            $user->groups->each(function ($group, $key) {
                $group->addUsersToDiscourseGroup($user->username);
            });
        }

        $user->save();
    }
}
