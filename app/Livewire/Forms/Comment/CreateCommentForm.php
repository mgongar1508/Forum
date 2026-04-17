<?php

namespace App\Livewire\Forms\Comment;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class CreateCommentForm extends Form
{
    public $post;
    public $parentId = null;

    public $body = '';

    public function submitForm()
    {
        $this->validate([
            'body' => 'required|string|min:1|max:5000',
        ]);

        Comment::create([
            'body' => $this->body,
            'commentable_id' => $this->post->id,
            'commentable_type' => get_class($this->post),
            'user_id' => Auth::id(),
            'parent_id' => $this->parentId,
        ]);

        $this->reset('body');

    }
}
