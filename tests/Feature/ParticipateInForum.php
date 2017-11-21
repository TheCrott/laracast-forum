<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForum extends TestCase
{
	use DatabaseMigrations;

	/** @test **/
    public function unauthenticated_user_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        /*
		$thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create();
        $this->post('/threads/'. $thread->id .'/replies', $reply->toArray());
        */
        $this->post('/threads/1/replies', []);
    }

    /** @test **/
    public function an_authenticated_user_may_participated_in_forum_threads()
    {
        // Given we have authenticated user and existing thread
        // When user add reply to thread, then reply should be included in page
        $this->be($user = factory('App\User')->create());
        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create();
        $this->post('/threads/'. $thread->id .'/replies', $reply->toArray());

        $this->get('/threads/' . $thread->id)->assertSee($reply->body);
    }
}
