<!DOCTYPE html>
<html>

<head>
    <title>Post</title>
    <style>
        table {
            border-collapse: collapse
        }
    </style>
</head>

<body>
    <h1>Post</h1>
    <table border="solid">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
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
                    <td class="py-2 text-center"><img style="width: 250px" src="{{ $post->image }}" alt="image"></td>
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
    

</body>

</html>
