<?php

namespace App\Livewire\Comment;

use App\Livewire\Post\PostShow;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CommentItem extends Component
{
    public Comment $comment;

    public $editing = false;
    public $replying = false;
    public $editBody = '';

    public function deleteComment()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! ($user->hasRole(['admin', 'moderator']) || $user->id === $this->comment->user_id)) {
            abort(403, 'Unauthorized');
        }

        $this->comment->delete();

        // Tell parent to refresh
        $this->dispatch('evtPostUpdated');
    }

    public function startEditComment()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! ($user->hasRole('admin') || $user->id === $this->comment->user_id)) {
            abort(403, 'Unauthorized');
        }

        $this->editing = true;
        $this->editBody = $this->comment->body;
    }

    public function updateComment()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! ($user->hasRole('admin') || $user->id === $this->comment->user_id)) {
            abort(403, 'Unauthorized');
        }

        $this->validate([
            'editBody' => 'required|string|min:1|max:5000',
        ]);

        $this->comment->update([
            'body' => $this->editBody,
        ]);

        $this->editing = false;

        $this->dispatch('evtPostUpdated')->to(PostShow::class);
    }

    public function startReply()
    {
        if (! Auth::user()) {
            return redirect()->route('login');
        }

        $this->replying = true;
    }

    #[On('reply-posted')]
    public function closeReply()
    {
        $this->replying = false;
        $this->dispatch('evtPostUpdated')->to(PostShow::class);
    }

    public function render()
    {
        return view('livewire.comment.comment-item');
    }
}
