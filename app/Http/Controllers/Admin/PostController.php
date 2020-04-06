<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function list()
    {
        $posts = Post::paginate(10);
        return view('admin.post.posts',compact('posts'));
    }
    public function post(Post $post)
    {
        $post->load(['user','category'])->loadCount('favorites');
        return view('admin.post.post',compact('post'));
    }
}
