<?php

namespace App\Livewire\Forms\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreatePostForm extends Form
{
    #[Validate(['required', 'string', 'min:3', 'max:200'])]
    public string $title = '';

    #[Validate(['required', 'string', 'min:10', 'max:10000'])]
    public string $body = '';

    #[Validate(['required', 'in:draft,published'])]
    public string $status = 'published';

    #[Validate(['boolean'])]
    public bool $is_locked = false;

    #[Validate(['boolean'])]
    public bool $is_pinned = false;

    #[Validate(['required', 'exists:subforums,id'])]
    public int $subforum_id = 0;

    #[Validate(['nullable', 'array', 'exists:tags,id'])]
    public array $tags = [];

    #[Validate(['nullable', 'array', 'max:10'])]
    public array $images = [];

    public function createPost()
    {
        $data = $this->validate();
        $this->validate([
            'images.*' => ['image', 'max:2048'], // 2MB per image
        ]);
        $data['user_id'] = Auth::id();
        $post = Post::create($data);
        if (! empty($this->tags)) {
            $post->tags()->attach($this->tags);
        }
        if (count($this->images) > 0) {
            foreach ($this->images as $image) {
                $path = $image->store('images', 'public');

                $post->images()->create([
                    'name' => $path,
                ]);
            }
        }
    }

    public function removeImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            // Re-index the array to avoid issues with missing keys
            $this->images = array_values($this->images);
        }
    }

    public function cancelForm()
    {
        $this->resetValidation();
        $this->reset();
    }
}
