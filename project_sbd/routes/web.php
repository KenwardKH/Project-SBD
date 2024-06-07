<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthorController;

// Route::get('/', function () {
//     return view('welcome');
// });




Route::get('/add-author', function () {
    return view('add-author');
});
Route::get('/', [PostController::class, 'index']);
Route::get('/add-post', [PostController::class, 'create']);
Route::post('/add-post',[PostController::class, 'store']);
Route::post('/add-author',[AuthorController::class, 'store']);
Route::get('/posts/search', [PostController::class, 'postsWithTag'])->name('posts.search');
Route::get('/monthly-post-updates', [PostController::class, 'monthlyPostUpdates'])->name('monthlyPostUpdates');
Route::get('/show-tag-posts', [PostController::class, 'ShowTagPosts'])->name('show-tag-posts');
Route::get('/show-cat-posts', [PostController::class, 'ShowCatPosts'])->name('show-cat-posts');
Route::get('/show-aut-posts', [PostController::class, 'ShowAutPosts'])->name('show-aut-posts');
Route::put('/update-post/{id}', [PostController::class, 'update'])->name('update-post');
Route::get('/delete-post/{id}', [PostController::class,  'destroy'])->name('delete-post');



