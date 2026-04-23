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

    public $filter = 'newest';

    public function loadMore()
    {
        $this->feedPage += 20;
    }

    #[On('evtPostCreated')]
    public function render()
    {
        $query = Post::with(['user', 'subforum', 'tags', 'images'])
            ->withCount([
                'likes as likes_count' => function ($q) {
                    $q->where('type', 'Like');
                },
                'likes as dislikes_count' => function ($q) {
                    $q->where('type', 'Dislike');
                },
                'comments',
            ])
            ->where('status', 'published');

        switch ($this->filter) {
            case 'likes':
                $query->orderByDesc('likes_count');
                break;

            case 'comments':
                $query->orderByDesc('comments_count');
                break;

            default:
                $query->orderByDesc('created_at');
                break;
        }

        $posts = $query->take($this->feedPage)->get();

        return view('livewire.main.home-feed', compact('posts'));
    }

    public function updatedFilter()
    {
        $this->feedPage = 10;
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
