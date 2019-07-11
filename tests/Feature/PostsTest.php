<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Post;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    public function refreshDatabase()
    {
        DB::connection('mongodb')->drop([]);
        $this->refreshTestDatabase();
    }

    public function testCreatePost()
    {
        $this->signIn();
        $attributes = factory(Post::class)->raw();
        $this->get('/admin/posts/create')->assertStatus(200);
        $this->post('/admin/posts/store', $attributes)->assertRedirect();
        $post = DB::connection('mongodb')->collection('posts')
                    ->where('title', $attributes['title'])
                    ->where('summary', $attributes['summary'])
                    ->where('detail', $attributes['detail'])
                    ->first();
        $this->assertTrue($post !== null);
    }

    public function testUpdatePost()
    {
        $this->signIn();
        $attributes = factory(Post::class)->raw();
        $this->post('/admin/posts/store', $attributes);
        $post = DB::connection('mongodb')->table('posts')
                    ->where('title', $attributes['title'])
                    ->where('summary', $attributes['summary'])
                    ->where('detail', $attributes['detail'])
                    ->first();
        $id = (string) $post['_id'];
        $this->get("/admin/posts/{$id}/edit")
                ->assertStatus(200)
                ->assertSee($attributes['title'])
                ->assertSee($attributes['summary']);
        // Update new content
        $attributes = factory(Post::class)->raw();
        $this->put("/admin/posts/{$id}/update", $attributes)->assertRedirect();
        $post = DB::connection('mongodb')->table('posts')
                    ->where('title', $attributes['title'])
                    ->where('summary', $attributes['summary'])
                    ->where('detail', $attributes['detail'])
                    ->first();
        $newId = (string) $post['_id'];
        $this->assertTrue($id === $newId);
    }

    public function testPublishPost()
    {
        $this->signIn();
        $attributes = factory(Post::class)->raw();
        $this->post('/admin/posts/store/1', $attributes);
        $post = DB::connection('mongodb')->table('posts')
                    ->where('title', $attributes['title'])
                    ->where('summary', $attributes['summary'])
                    ->where('detail', $attributes['detail'])
                    ->first();
        $this->assertTrue($post['is_published'] == Post::IS_PUBLISHED_YES);
        $this->assertTrue(!empty($post['published_at']));
    }

    public function testViewAllPosts()
    {
        $this->signIn();
        $this->get('/admin/posts')->assertStatus(200);
    }
}
