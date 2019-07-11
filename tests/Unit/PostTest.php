<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Post;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function refreshDatabase()
    {
        DB::connection('mongodb')->drop([]);
    }

    public function testCreate()
    {
        $model = factory(Post::class)->create();
        $savedModel = Post::find($model->_id);
        $this->assertTrue($savedModel !== null);
    }

    public function testDefaultValues()
    {
        $model = factory(Post::class)->create();
        $this->assertTrue($model->is_published === Post::IS_PUBLISHED_NO);
        $this->assertTrue($model->is_deleted === Post::IS_DELETED_NO);
    }

    public function testSlugGenerated()
    {
        $model = factory(Post::class)->create();
        $this->assertTrue($model->slug !== '');
    }
}
