<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Post;

class PublicPostsTest extends TestCase
{
    use RefreshDatabase;

    public function refreshDatabase()
    {
        DB::connection('mongodb')->drop([]);
        $this->refreshTestDatabase();
    }

    public function testViewsAllPosts()
    {
        $this->get('/')->assertStatus(200);
    }

    public function testViewsPostDetail()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $attributes = factory(Post::class)->raw();
        $this->post('/admin/posts/store/1', $attributes);
        $post = DB::connection('mongodb')->table('posts')
                    ->where('title', $attributes['title'])
                    ->where('summary', $attributes['summary'])
                    ->where('detail', $attributes['detail'])
                    ->first();
        $id = (string) $post['_id'];
        $this->get('/view/'.$id)->assertStatus(200);
    }
}
