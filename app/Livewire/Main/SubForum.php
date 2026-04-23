<?php

namespace App\Livewire\Main;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\Subforum as ModelsSubforum;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SubForum extends Component
{
    public $subforum;

    public $feedPage = 10;

    public $filter = 'newest';

    public function mount(ModelsSubforum $subforum)
    {
        $this->subforum = $subforum;
    }

    public function loadMore()
    {
        $this->feedPage += 20;
    }

    public function followSubforum()
    {
        if (! Auth::user()) {
            return redirect()->route('login');
        }

        Auth::user()->subforums()->toggle($this->subforum->id);
        $this->dispatch('sFollowed')->to(SideBar::class);
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

    public function render()
    {
        $query = Post::with([
            'user',
            'tags',
            'images',
            'likes' => function ($q) {
                if (Auth::user()) {
                    $q->where('user_id', Auth::id());
                }
            },
        ])
            ->withCount([
                'likes as likes_count' => fn ($q) => $q->where('type', 'Like'),
                'likes as dislikes_count' => fn ($q) => $q->where('type', 'Dislike'),
                'comments',
            ])
            ->where('subforum_id', $this->subforum->id)
            ->where('status', 'published')
            ->where('is_pinned', false);

        // Apply filter
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
        // Final result
        $posts = $query
            ->take($this->feedPage)
            ->get();

        $pinnedPosts = Post::with(['user', 'tags', 'images'])
            ->where('subforum_id', $this->subforum->id)
            ->where('is_pinned', true)
            ->latest()
            ->get();

        $isFollowing = Auth::user() &&
        Auth::user()->subforums->contains($this->subforum->id);

        return view('livewire.main.sub-forum', [
            'posts' => $posts,
            'pinnedPosts' => $pinnedPosts,
            'isFollowing' => $isFollowing,
        ]);
    }
}
