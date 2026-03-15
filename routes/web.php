<?php

use App\Livewire\Main\HomeFeed;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeFeed::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
});
