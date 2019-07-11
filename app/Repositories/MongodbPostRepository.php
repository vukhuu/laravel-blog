<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Post;

class MongodbPostRepository implements PostRepositoryInterface
{
    public function findAll()
    {
        $posts = DB::connection('mongodb')
                    ->collection('posts')
                    ->where('is_deleted', Post::IS_DELETED_NO)
                    ->orderBy('published_at', 'desc')
                    ->get();
        return $posts;
    }

    public function findAllPublishedPosts()
    {
        $posts = DB::connection('mongodb')
                    ->collection('posts')
                    ->where('is_deleted', Post::IS_DELETED_NO)
                    ->where('is_published', Post::IS_PUBLISHED_YES)
                    ->orderBy('published_at', 'desc')
                    ->get();
        return $posts;
    }
}