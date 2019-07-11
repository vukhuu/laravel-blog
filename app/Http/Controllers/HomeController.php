<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Repositories\PostRepositoryInterface;

class HomeController extends Controller
{
    /**
     * Show all posts to user
     * @param PostRepositoryInterface $postRepository
     */
    public function index(PostRepositoryInterface $postRepository)
    {
        $posts = $postRepository->findAllPublishedPosts();
        return view('home.index', compact('posts'));
    }

    /**
     * View detail of a post
     * @param Post $post
     */
    public function view(Post $post)
    {
        return view('home.view', compact('post'));
    }
}
