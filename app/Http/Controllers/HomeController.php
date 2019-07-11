<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Repositories\PostRepositoryInterface;

class HomeController extends Controller
{
    public function index(PostRepositoryInterface $postRepository)
    {
        $posts = $postRepository->findAllPublishedPosts();
        return view('home.index', compact('posts'));
    }

    public function view(Post $post)
    {
        return view('home.view', compact('post'));
    }
}
