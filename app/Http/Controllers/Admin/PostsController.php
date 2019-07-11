<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Repositories\PostRepositoryInterface;

class PostsController extends Controller
{
    public function create()
    {
        $post = new Post();
        $isCreateNew = true;
        return view('admin.posts.createOrUpdate', compact('post', 'isCreateNew'));
    }

    public function store($isPublished = 0)
    {
        request()->validate([
            'title' => 'required',
        ]);
        $attributes = request()->all();
        $attributes['created_by'] = auth()->user()->id;

        $post = new Post();
        $post = $post->create($attributes);
        $message = __('messages.postSavedSuccessfully');
        if ($isPublished) {
            $post->publish();
            $message = __('messages.postPublishedSuccessfully');
        }
        
        return redirect(url("/admin/posts/{$post->_id}/edit"))->with('message', $message);
    }

    public function edit(Post $post)
    {
        $isCreateNew = false;
        return view('admin.posts.createOrUpdate', compact('post', 'isCreateNew'));
    }

    public function update(Post $post, $isPublished = 0)
    {
        request()->validate([
            'title' => 'required',
        ]);
        $attributes = request()->all();
        $post->update($attributes);
        $message = __('messages.postUpdatedSuccessfully');
        if ($isPublished) {
            $post->publish();
            $message = __('messages.postPublishedSuccessfully');
        }
        return redirect(url("/admin/posts/{$post->_id}/edit"))->with('message', $message);
    }

    public function index(PostRepositoryInterface $postRepository)
    {
        $posts = $postRepository->findAll();
        return view('admin.posts.index', compact('posts'));
    }

    public function delete(Post $post)
    {
        $post->delete();
    }
}
