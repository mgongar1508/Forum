<?php

use App\Http\Controllers\Admin\SubforumController;
use App\Http\Controllers\Admin\TagController;
use App\Livewire\Main\HomeFeed;
use App\Livewire\Main\SearchResult;
use App\Livewire\Main\SubForum;
use App\Livewire\Main\UserPost;
use App\Livewire\Post\PostShow;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeFeed::class)->name('home');
Route::get('/post/{post}', PostShow::class)->name('post.view');
Route::get('/s/{subforum:slug}', SubForum::class)->name('subforum.view');
Route::get('/search', SearchResult::class)->name('search');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/userPosts', UserPost::class)->name('userPosts.view');

    Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::resource('tags', TagController::class);
    });

    Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::resource('subforums', SubforumController::class);
    });
});
