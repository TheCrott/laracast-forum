<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    /** @test **/
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');

        // $response->assertStatus(200);
        $response->assertSee($this->thread->title);
    }

    /** @test **/
    public function a_user_can_view_a_single_threads()
    {
        $response = $this->get('/threads/' . $this->thread->id);
        $response->assertSee($this->thread->title);
    }

    /** @test **/
    public function a_user_can_read_replies_that_associated_with_a_thread()
    {
        // given thread
        // and that thread include replies
        // When we visit a thread page
        // Then we should see replies

        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
        $response = $this->get('/threads/' . $this->thread->id);
        $response->assertSee($reply->body);
    }
}
