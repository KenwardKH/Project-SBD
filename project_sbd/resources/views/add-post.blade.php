@extends('layout')

@section('title', 'Add Post')

@section('page-title', 'Add Post')

@section('content')
<link rel="stylesheet" href="{{ asset('css/add-post.css') }}">
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
                @foreach($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Create Post</button>
    </form>
    </div>
    
@endsection
