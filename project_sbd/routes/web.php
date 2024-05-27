<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItineraryController;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);

Route::get('/posts/search', [PostController::class, 'postsWithTag'])->name('posts.search');



