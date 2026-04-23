<?php

use App\Livewire\Main\HomeFeed;
use App\Livewire\Main\SubForum;
use App\Livewire\Post\PostShow;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeFeed::class)->name('home');
Route::get('/post/{post}', PostShow::class)->name('post.view');
Route::get('/s/{subforum:slug}', SubForum::class)
    ->name('subforum.view');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
});
