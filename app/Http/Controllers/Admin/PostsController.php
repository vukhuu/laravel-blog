<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Repositories\PostRepositoryInterface;

class PostsController extends Controller
{
    /**
     * Page to create a blog post
     */
    public function create()
    {
        $post = new Post();
        $isCreateNew = true;
        return view('admin.posts.createOrUpdate', compact('post', 'isCreateNew'));
    }

    /**
     * Store a post via POST method
     * @param bool $isPublished
     */
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

    /**
     * Load page to edit a post
     * @param Post $post
     */
    public function edit(Post $post)
    {
        $isCreateNew = false;
        return view('admin.posts.createOrUpdate', compact('post', 'isCreateNew'));
    }

    /**
     * Update a post via PUT request
     * @param Post $post
     * @param bool $isPublished
     */
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

    /**
     * Show all posts to admin
     * @param PostRepositoryInterface $postRepository
     */
    public function index(PostRepositoryInterface $postRepository)
    {
        $posts = $postRepository->findAll();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Delete a post
     * @param Post $post
     */
    public function delete(Post $post)
    {
        $post->delete();
    }
}
