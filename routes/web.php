<?php

use App\Livewire\Main\HomeFeed;
use App\Livewire\Post\PostShow;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeFeed::class)->name('home');
Route::get('/post/{post}', PostShow::class)->name('post.view');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
});
