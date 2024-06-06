<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Author;
use DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all posts from the database
        $posts = Post::with('author', 'categories', 'tags')->paginate(10);

        // Fetch categories and tags for dropdowns
        $categories = Category::all();
        $tags = Tag::all();

        // Return the view with the posts, categories, and tags data
        return view('post', ['posts' => $posts, 'categories' => $categories, 'tags' => $tags]);
    }


    public function monthlyPostUpdates()
    {
        $monthlyUpdates = Post::select(
                DB::raw('IF((YEAR(date_updated) < 2020), "Before 2020", CONCAT(YEAR(date_updated), "-", LPAD(MONTH(date_updated), 2, "0"))) as period'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('period')
            ->orderByRaw('MIN(date_updated)')
            ->get();
    
        return view('monthly-post-updates', compact('monthlyUpdates'));
    }
    public function ShowTagPosts()
    {
        $tagUpdates = DB::table('post_tags')
            ->join('tags', 'post_tags.tag_id', '=', 'tags.id')
            ->select(
                'tags.name as tag',
                DB::raw('COUNT(post_tags.post_id) as count')
            )
            ->groupBy('tags.name')
            ->orderBy('count','desc')
            ->get();

        return view('show-tag-posts', compact('tagUpdates'));
    }
    public function ShowCatPosts()
    {
        $catUpdates = DB::table('post_categories')
            ->join('categories', 'post_categories.category_id', '=', 'categories.id')
            ->select(
                'categories.name as cat',
                DB::raw('COUNT(post_categories.post_id) as count')
            )
            ->groupBy('categories.name')
            ->orderBy('count','desc')
            ->get();

        return view('show-cat-posts', compact('catUpdates'));
    }

    

    public function postsWithTag(Request $request)
    {
        $category = $request->input('category');
        $tag = $request->input('tag');
        $title = $request->input('title');
        $sort = $request->input('sort', 'date_updated');
        $direction = $request->input('direction', 'asc');

        // Fetch posts based on search criteria
        $query = Post::query();

        if ($category) {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category);
            });
        }

        if ($tag) {
            $query->whereHas('tags', function ($query) use ($tag) {
                $query->where('tags.id', $tag);
            });
        }

        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        if ($sort && in_array($sort, ['id', 'date_updated'])) {
            $query->orderBy($sort, $direction);
        }

        $posts = $query->paginate(10);

        // Append search terms to the pagination links
        $posts->appends([
            'category' => $category,
            'tag' => $tag,
            'title' => $title,
            'sort' => $sort,
            'direction' => $direction,
        ]);

        // Fetch categories and tags for dropdowns
        $categories = Category::all();
        $tags = Tag::all();

        return view('post', ['posts' => $posts, 'categories' => $categories, 'tags' => $tags]);
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
            // Save new post with the current date and time
            $post = Post::create([
                'title' => $request->input('title'),
                'image' => $request->input('image'),
                'slug' => $request->input('slug'),
                'author_id' => $request->input('author'),
                'date_updated' => now(), // Set date_updated to the current date and time
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
