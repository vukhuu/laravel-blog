<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Repositories\MongodbPostRepository;
use App\Post;

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function refreshDatabase()
    {
        DB::connection('mongodb')->drop([]);
    }

    public function testFindAll()
    {
        $model = factory(Post::class)->create();

        $repo = new MongodbPostRepository();
        $posts = $repo->findAll();
        $this->assertTrue($posts->count() === 1);
    }
}
