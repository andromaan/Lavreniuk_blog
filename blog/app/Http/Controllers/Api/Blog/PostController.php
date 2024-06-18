<?php

namespace App\Http\Controllers\Api\Blog;

use App\Models\BlogPost;

class PostController
{
    public function index()
    {
        $posts = BlogPost::with(['user', 'category'])->get();

        return $posts;
    }
    public function show($id)
    {
        $post = BlogPost::with(['user', 'category'])->findOrFail($id);

        return $post;
    }

}
