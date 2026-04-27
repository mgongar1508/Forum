<?php

namespace App\Livewire\Main;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Url;

class SearchResult extends Component
{
    #[Url(as: 'q')]
    public string $q = '';

    public int $limit = 20;

    public function loadMore()
    {
        $this->limit += 20;
    }

    public function render()
    {
        $posts = Post::with(['user', 'subforum', 'tags', 'images'])
            ->withCount([
                'likes as likes_count' => fn($q) => $q->where('type', 'Like'),
                'likes as dislikes_count' => fn($q) => $q->where('type', 'Dislike'),
                'comments',
            ])
            ->where('status', 'published')
            ->where(function ($query) {
                $query->where('title', 'like', "%{$this->q}%")
                      ->orWhere('body', 'like', "%{$this->q}%");
            })
            ->orderByDesc('created_at')
            ->take($this->limit)
            ->get();

        return view('livewire.main.search-result', compact('posts'));
    }
}
