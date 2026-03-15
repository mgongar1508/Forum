<?php

namespace App\Livewire\Main;

use App\Models\Post;
use Livewire\Component;

class HomeFeed extends Component
{
    public function render()
    {
        $posts = Post::all()->where('status', 'published');
        return view('livewire.main.home-feed', compact('posts'));
    }
}
