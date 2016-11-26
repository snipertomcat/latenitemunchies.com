<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPostsTableNotEmpty()
    {
        $posts = App\Post::all(); // using the 'wordpress' connection
        $this->assertNotEmpty($posts);
    }
}
