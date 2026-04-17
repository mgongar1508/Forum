<?php

namespace App\Livewire\Comment;

use App\Livewire\Forms\Comment\CreateCommentForm;
use App\Livewire\Post\PostShow;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateComment extends Component
{
    public CreateCommentForm $form;

    public $post;

    public $parentId = null;

    public function mount($post, $parentId = null)
    {
        $this->post = $post;
        $this->parentId = $parentId;

        $this->form->post = $post;
        $this->form->parentId = $parentId;
    }

    public function submit()
    {
        if (! Auth::user()) {
            return redirect()->route('login');
        }
        $this->form->submitForm();
        $this->dispatch('evtPostUpdated')->to(PostShow::class);
        $this->dispatch('reply-posted')->to(CommentItem::class);
    }

    public function render()
    {
        return view('livewire.comment.create-comment');
    }
}
