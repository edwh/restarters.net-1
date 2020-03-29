<?php

namespace Tests\Feature;

use App\Events\ApproveEvent;
use App\Events\EditEvent;
use App\Group;
use App\Party;
use App\User;

use DB;
use Carbon\Carbon;
use Mockery;
use Tests\TestCase;
use HieuLe\WordpressXmlrpcClient\WordpressClient;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WordpressPushTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        DB::statement("SET foreign_key_checks=0");
        User::truncate();
        Group::truncate();
        Party::truncate();
        DB::statement("SET foreign_key_checks=1");
    }

    /** @test */
    public function events_pushed_to_wordpress_when_approved()
    {
        $this->instance(WordpressClient::class, Mockery::mock(WordpressClient::class, function ($mock) {
            $mock->shouldReceive('newPost')->once();
        }));

        $event = factory(Party::class)->create();

        $eventData = factory(Party::class)->raw();
        $eventData['moderate'] = 'approve';
        $eventData['latitude'] = '1';
        $eventData['longitude'] = '1';

        event(new ApproveEvent($event, $eventData));
    }

    /** @test */
    public function events_pushed_to_wordpress_when_edited()
    {
        $this->instance(WordpressClient::class, Mockery::mock(WordpressClient::class, function ($mock) {
            $mock->shouldReceive('getPost')->andReturn(100);
            $mock->shouldReceive('editPost')->once();
        }));

        $event = factory(Party::class)->create();
        $event->wordpress_post_id = 100;
        $event->save();

        $eventData = factory(Party::class)->raw();
        $eventData['free_text'] = 'Some change';
        $eventData['latitude'] = '1';
        $eventData['longitude'] = '1';

        event(new EditEvent($event, $eventData));
    }
}
