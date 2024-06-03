<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/add-post.css') }}">
</head>

<body>
    <div class="container">
        <form action="/add-post" method="POST" class="main">
        @csrf
        <div class="input">
            <label for="title">Title</label>
            <input type="text" id="title" name="title">
        </div>
        <div class="input">
            <label for="image">Image URL</label>
            <input type="text" id="image" name="image">
        </div>
        <div class="input">
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug">
        </div>
        
        <div class="input">
            <label for="categories">Categories (comma separated)</label>
            <input type="text" id="categories" name="categories">
        </div>
        
        <div class="input">
            <label for="tags">Tags (comma separated)</label>
            <input type="text" id="tags" name="tags">
        </div>
        
        <div class="input">
            <label for="author">Author</label>
            <select name="author" id="author">
                <option value="1">Lina Stock</option>
                <option value="2">Heather Halpern</option>
                <option value="3">David Stock</option>
                <option value="4">Guest Writer</option>
            </select>
        </div>
        <button type="submit">Create Post</button>
    </form>
    </div>
    
</body>

</html>
