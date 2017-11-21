<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

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

    /** @test **/
    public function a_thread_has_a_creator()
    {
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('App\User', $thread->creator);
    }

    /** @test **/
    public function a_thread_has_a_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }
    
    /** @test **/
    public function a_thread_can_add_a_reply() {
        $this->thread->addReply([
            'body' => 'Testing',
            'user_id' => 1
        ]);
        $this->assertCount(1, $this->thread->replies);
    }
}
