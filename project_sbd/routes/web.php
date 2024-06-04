<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItineraryController;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);
Route::get('/add-post', [PostController::class, 'create']);
Route::post('/add-post',[PostController::class, 'store']);
Route::get('/posts/search', [PostController::class, 'postsWithTag'])->name('posts.search');
Route::get('/monthly-post-updates', [PostController::class, 'monthlyPostUpdates'])->name('monthlyPostUpdates');




