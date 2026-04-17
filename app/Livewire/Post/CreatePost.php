<?php

namespace App\Livewire\Post;

use App\Livewire\Forms\Post\CreatePostForm;
use App\Livewire\Main\HomeFeed;
use App\Models\Subforum;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public CreatePostForm $cform;

    public bool $openCreate = false;

    public function render()
    {
        return view('livewire.post.create-post', [
            'subforums' => Subforum::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        $this->cform->createPost();
        $this->cancel();
        $this->dispatch('message', 'Post Created');
        $this->dispatch('evtPostCreated')->to(HomeFeed::class);
    }

    public function removeImage($index)
    {
        $this->cform->removeImage($index);
    }

    public function cancel()
    {
        $this->openCreate = false;
        $this->cform->cancelForm();
    }
}
