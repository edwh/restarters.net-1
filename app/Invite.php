<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invite extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'record_id', 'hash', 'type',
    ];

    public function group()
    {
        if ($this->type == 'group') {
            return $this->belongsTo(Group::class, 'record_id', 'idgroups');
        }
    }

    public function event()
    {
        if ($this->type == 'event') {
            return $this->belongsTo(Party::class, 'record_id', 'idevents');
        }
    }
}
