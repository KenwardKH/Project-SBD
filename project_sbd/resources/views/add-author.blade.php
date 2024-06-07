@extends('layout')

@section('title', 'Dashboard')

@section('page-title', 'Add New Author')

@section('content')
<link rel="stylesheet" href="{{ asset('css/add-post.css') }}">
    <div class="container">
        <form action="/add-author" method="POST" class="main">
        @csrf
        <div class="input">
            <label for="name">Author Name</label>
            <input type="text" id="name" name="name">
            <button class="btn btn-primary" type="submit">Create New Author</button>
        </div>
        
    </form>
    </div>
    
@endsection
