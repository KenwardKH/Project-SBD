<!DOCTYPE html>
<html>

<head>
    <title>Post</title>
    <link rel="stylesheet" href="{{ asset('css/post.css') }}">
</head>

<body>
    <div class="main">
    <h1>Post</h1>
    <form action="{{ route('posts.search') }}" method="GET">
        <input class="search" type="text" name="search" placeholder="Search by tag..." value="{{ request('search') }}">
        <button class="hidden xl:inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ml-1 sm:ml-3" type="submit">Search</button>
    </form>
    <table border="solid">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th style="width: 250px">Content</th>
                <th>Slug</th>
                <th>Date Posted</th>
                <th>Category</th>
                <th>Tags</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td class="img text-center"><img class="image" style="width: 250px" src="{{ $post->image }}" alt="image"></td>
                    <td>{{ $post->slug }}</td>
                    <td>{{ $post->date_posted }}</td>
                    <td>
                        <ul>
                            @foreach ($post->categories as $category)
                                <li>{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul>
                            @foreach ($post->tags as $tag)
                                <li>{{ $tag->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $posts->links() }}
    </div>
    
    </div>
</body>

</html>
