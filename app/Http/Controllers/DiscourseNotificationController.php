<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class DiscourseNotificationController extends Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');

        // Check here if the user is authenticated
        if ( ! Auth::check()) {
            return response()->json([
                'message' => 'failed',
            ]);
        }
    }

    public function __invoke(Request $request)
    {
        if ( ! $_COOKIE['has_cookie_notifications_set']) {
            $this->handleRequest();
        }

        // 10 Minutes
        setcookie('has_cookie_notifications_set', true, time() + (60 * 10), url('/'));

        // Return discourse notifications within the console
        return response()->json([
            'notifications' => Auth::user()->unReadNotifications->sortBy('created_at')->take(10),
            'message' => 'success',
        ]);
    }

    private function handleRequest()
    {
        $client = app('discourse-client', ['username' => Auth::user()->username]);

        $response = $client->request('GET', '/notifications.json', [
            'query' => [
                'username' => Auth::user()->username,
            ],
        ]);

        if ($response->getStatusCode() != 200 || $response->getReasonPhrase() != 'OK') {
            return response()->json([
                'message' => 'failed',
            ]);
        }

        $array = json_decode($response->getBody()->getContents(), true);

        return collect($array['notifications'])->reject(function ($discourse_notification) {
            return $discourse_notification['read'];
        })->each(function ($discourse_notification) {
            DatabaseNotification::firstOrCreate(
                [
                    'id' => $discourse_notification['id'],
                ],
                [
                    'type' => '',
                    'notifiable_type' => 'App\User',
                    'notifiable_id' => $this->user_id ?? Auth::user()->id,
                    'data' => [
                        'title' => $discourse_notification['fancy_title'],
                        'name' => $discourse_notification['name'],
                        'url' => $this->generateUrl($discourse_notification),
                    ],
                    'read_at' => null,
                ]
            );
        });
    }

    private function generateUrl(array $discourse_notification)
    {
        $key = array_key_first($discourse_notification['data']);

        $username = Auth::user()->username;
        if ($this->username) {
            $username = $this->username;
        }

        if (str_contains($key, 'topic')) {
            $prepend = 't';
            $slug = sprintf(
                '%s/%s/%s',
                $discourse_notification['slug'],
                $discourse_notification['topic_id'],
                $discourse_notification['post_number']
            );
        }

        if (str_contains($key, 'badge')) {
            $prepend = 'badges';
            $slug = sprintf(
                '%s/%s?',
                $discourse_notification['data']['badge_id'],
                $discourse_notification['data']['badge_slug'],
                "username={$username}"
            );
        }

        $url = sprintf(
            '%s/%s/%s',
            env('DISCOURSE_URL'),
            $prepend,
            $slug
        );

        return $url;
    }
}
