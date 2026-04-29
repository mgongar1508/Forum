<?php

use App\Http\Controllers\Admin\SubforumController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
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

    Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
        Route::put('users/{user}/roles', [UserController::class, 'updateRoles'])->name('admin.users.roles');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });
});
