<?php

namespace App\Livewire\Main;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class HomeFeed extends Component
{
    public $feedPage = 10;

    public function loadMore()
    {
        $this->feedPage += 20;
    }

    #[On('evtPostCreated')]
    public function render()
    {
        $posts = Post::with(['user', 'subforum', 'tags', 'likes', 'images'])
            ->where('status', 'published')
            ->take($this->feedPage)
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
