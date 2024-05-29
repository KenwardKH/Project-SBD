<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="/add-post" method="POST">
        @csrf
        <label for="title">Title</label>
        <input type="text" id="title" name="title">
    
        <label for="image">Image URL</label>
        <input type="text" id="image" name="image">
    
        <label for="categories">Categories (comma separated)</label>
        <input type="text" id="categories" name="categories">
    
        <label for="tags">Tags (comma separated)</label>
        <input type="text" id="tags" name="tags">
    
        <button type="submit">Create Post</button>
    </form>
</body>

</html>
