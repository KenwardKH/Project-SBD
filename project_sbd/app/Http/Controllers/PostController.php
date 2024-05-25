<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all posts from the database
        $posts = Post::paginate(10);

        // Return the view with the posts data
        return view('post', ['posts' => $posts]);
    }

    public function postsWithTag(Request $request)
    {
        $tagName = $request->input('search');

        // Fetch posts that have the specified tag
        $posts = Post::select('posts.id', 'posts.title', 'posts.image', 'posts.date_posted')
            ->join('post_tags', 'posts.id', '=', 'post_tags.post_id')
            ->join('tags', 'post_tags.tag_id', '=', 'tags.id')
            ->where('tags.name', $tagName)
            ->paginate(10); // Using pagination for better performance

        // Append the search term to the pagination links
        $posts->appends(['search' => $tagName]);

        return view('post', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
