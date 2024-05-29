<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use DB;

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
    $searchTerm = $request->input('search');

    // Fetch unique posts that have the specified tag, title, or category name
    $posts = Post::select('posts.id', 'posts.title', 'posts.image', 'posts.date_posted')
        ->join('post_tags', 'posts.id', '=', 'post_tags.post_id')
        ->join('tags', 'post_tags.tag_id', '=', 'tags.id')
        ->join('post_categories', 'posts.id', '=', 'post_categories.post_id')
        ->join('categories', 'post_categories.category_id', '=', 'categories.id')
        ->where(function($query) use ($searchTerm) {
            $query->where('tags.name', $searchTerm)
                  ->orWhere('posts.title', 'like', '%' . $searchTerm . '%')
                  ->orWhere  ('categories.name', 'like', '%' . $searchTerm . '%');
        })
        ->distinct() // Ensure distinct posts are selected
        ->paginate(10); // Using pagination for better performance

    // Append the search term to the pagination links
    $posts->appends(['search' => $searchTerm]);

    return view('post', ['posts' => $posts]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add-post');
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            // Save new post
            $post = Post::create([
                'title' => $request->input('title'),
                'image' => $request->input('image')
            ]);

            // Save new categories if not exist
            $categories = explode(',', $request->input('categories'));
            foreach ($categories as $categoryName) {
                $category = Category::firstOrCreate(['name' => trim($categoryName)]);
                $post->categories()->attach($category->id);
            }

            // Save new tags if not exist
            $tags = explode(',', $request->input('tags'));
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $post->tags()->attach($tag->id);
            }
        });

        return redirect('/posts');
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
