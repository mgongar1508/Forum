<?php

namespace App\Livewire\Forms\Post;

use App\Models\Post;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdatePostForm extends Form
{
    public ?Post $post = null;

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
    public array $images = []; // new uploaded images

    public function setPost(Post $post)
    {
        $this->post = $post;
        $this->title = $post->title ?? '';
        $this->body = $post->body ?? '';
        $this->status = $post->status;
        $this->is_locked = $post->is_locked;
        $this->is_pinned = $post->is_pinned;
        $this->subforum_id = $post->subforum_id;
        $this->tags = $post->tags()->pluck('id')->toArray();
    }

    public function updatePost()
    {
        $data = $this->validate();

        $this->validate([
            'images.*' => ['image', 'max:2048'],
        ]);

        // Update main post fields
        $this->post->update($data);

        // Sync tags
        $this->post->tags()->sync($this->tags);

        // Add new images
        if (! empty($this->images)) {
            foreach ($this->images as $image) {
                $path = $image->store('images', 'public');

                $this->post->images()->create([
                    'name' => $path,
                ]);
            }
        }
    }

    public function cancelForm()
    {
        $this->resetValidation();
        $this->reset();
        $this->post = null;
    }
}
