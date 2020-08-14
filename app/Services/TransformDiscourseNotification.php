<?php

namespace App\Services;

use Illuminate\Http\Resources\Json\JsonResource;

class TransformDiscourseNotification extends JsonResource
{
    /**
     * @var object
     */
    private $notification;

    /**
     * @var string
     */
    private $notification_url;

    /**
     * @var array
     */
    private $basic_notification_types = [
        'mentioned' => 1,
        'replied' => 2,
        'quoted' => 3,
        'edited' => 4,
        'liked' => 5,
        'private_message' => 6,
        'invited_to_private_message' => 7,
    ];

    public function __construct($notification)
    {
        $this->notification = (object) $notification;

        if (in_array($this->notification->notification_type, $this->basic_notification_types)) {
            $this->constructBasicNotificationURL();
        } else {
            $this->notification_url = rtrim(env('DISCOURSE_URL'), '/')."/my/notifications";
        }
    }

    private function constructBasicNotificationURL()
    {
        $this->notification_url = rtrim(env('DISCOURSE_URL'), '/')."/t/{$this->notification->slug}/{$this->notification->topic_id}";
    }

    /**
      * Transform the resource into an array.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return array
      */
    public function toArray($request)
    {
        return [
            'title' => $this->notification->fancy_title ?? 'New Notification',
            'name' => $this->notification->fancy_title ?? 'New Notification',
            'url' => $this->notification_url,
        ];
    }

}
