<?php

namespace App\Livewire\Main;

use App\Models\Post;
use App\Models\Subforum as ModelsSubforum;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SubForum extends Component
{
    public $subforum;

    public $feedPage = 10;

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
        $this->dispatch("sFollowed")->to(SideBar::class);
    }

    public function render()
    {
        $posts = Post::with(['user', 'tags', 'likes', 'images'])
            ->where('subforum_id', $this->subforum->id)
            ->where('status', 'published')
            ->where('is_pinned', false)
            ->latest()
            ->take($this->feedPage)
            ->get();

        $pinnedPosts = Post::with(['user', 'tags', 'likes', 'images'])
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
