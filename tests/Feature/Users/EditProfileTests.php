<?php

namespace Tests\Feature;

use App\Events\UserUpdated;
use App\User;

use DB;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NetworkTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        DB::statement("SET foreign_key_checks=0");
        User::truncate();
        DB::statement("SET foreign_key_checks=1");
    }

    /** @test */
    // The assertion just tells us that the event is dispatched, not much else.
    // In order to actually check it worked, we need to look at Discourse.
    public function email_address_update_triggers_discourse_sync()
    {
        $this->withoutExceptionHandling();
        Event::fake();

        // arrange
        config(['restarters.features.discourse_integration' => true]);

        $user = factory(User::class)->create(['id' => 1111177]);

        // act
        $user->email = 'foo@bario.com';
        $user->save();

        // assert
        Event::assertDispatched(UserUpdated::class);
    }
}
