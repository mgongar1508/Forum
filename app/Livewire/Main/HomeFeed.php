<?php

namespace App\Livewire\Main;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HomeFeed extends Component
{
    public function render()
    {
        $posts = $posts = Post::with(['user', 'subforum', 'tags', 'likes', 'images'])
            ->where('status', 'published')
            ->get();

        return view('livewire.main.home-feed', compact('posts'));
    }

    public function likePost($postId, $given)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();

        PostLike::where('user_id', $userId)
            ->where('post_id', $postId)
            ->delete();

        PostLike::create([
            'user_id' => $userId,
            'post_id' => $postId,
            'type' => $given,
        ]);
    }
}
