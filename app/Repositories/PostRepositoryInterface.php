<?php
namespace App\Repositories;

interface PostRepositoryInterface
{
    /**
     * Find all posts
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function findAll();

    /**
     * Find all published posts
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function findAllPublishedPosts();
}