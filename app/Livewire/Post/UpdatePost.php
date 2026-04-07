<?php

namespace App\Livewire\Post;

use App\Livewire\Forms\Post\UpdatePostForm;
use App\Models\Post;
use App\Models\Subforum;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdatePost extends Component
{
    use WithFileUploads;

    public UpdatePostForm $uform;

    public bool $openUpdate = false;
    public Post $post;
    public int $postId;

    public function mount($postId)
    {
        $this->postId = $postId;

        $post = Post::findOrFail($postId);

        $this->uform->setPost($post);
    }

    public function render()
    {
        $user = Auth::user();

        if (! $user->hasRole('admin') && $this->uform->post->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return view('livewire.post.update-post', [
            'subforums' => Subforum::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function update()
    {
        $this->uform->updatePost();
        $this->cancel();

        $this->dispatch('message', 'Post Updated');
        $this->dispatch('evtPostUpdated')->to(PostShow::class);
    }

    public function cancel()
    {
        $this->openUpdate = false;
        $this->uform->cancelForm();
    }
}
