<?php

namespace App\Livewire\Forms\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class UpdatePostForm extends Form
{
    use WithFileUploads;
    
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
    public $images = []; // new uploaded images

    // Track existing images and deletions
    public array $existingImages = [];

    public array $deletedImages = [];

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

        $this->existingImages = $post->images()->get(['id', 'name'])->toArray();
    }

    public function updatePost()
    {
        $this->validate(); // Validates title, body, etc.

        // Explicitly validate the images
        $this->validate([
            'images.*' => ['image', 'max:2048'],
        ]);

        $this->post->update([
            'title' => $this->title,
            'body' => $this->body,
            'status' => $this->status,
            'subforum_id' => $this->subforum_id,
            'is_locked' => $this->is_locked,
            'is_pinned' => $this->is_pinned,
        ]);

        $this->post->tags()->sync($this->tags);

        // 1. Handle Deletions
        if (! empty($this->deletedImages)) {
            $imagesToDestroy = $this->post->images()->whereIn('id', $this->deletedImages)->get();
            foreach ($imagesToDestroy as $img) {
                Storage::disk('public')->delete($img->name);
                $img->delete();
            }
        }

        // 2. Handle New Uploads
        if ($this->images) {
            foreach ($this->images as $image) {
                $path = $image->store('images', 'public');
                $this->post->images()->create(['name' => $path]);
            }
        }

        // Reset state
        $this->images = [];
        $this->deletedImages = [];
        // Refresh existing images for the UI
        $this->existingImages = $this->post->images()->get(['id', 'name'])->toArray();
    }

    public function removeExistingImage($imageId)
    {
        $this->deletedImages[] = $imageId;
        $this->existingImages = array_filter($this->existingImages, fn ($img) => $img['id'] !== $imageId);
    }

    public function removeNewImage($index)
    {
        $currentImages = is_array($this->images) ? $this->images : [$this->images];
        if (isset($currentImages[$index])) {
            unset($currentImages[$index]);
            $this->images = array_values($currentImages);
        }
    }

    public function cancelForm()
    {
        $this->resetValidation();
        // IMPORTANT: Reset only specific fields so we don't nuke the $post instance
        $this->title = $this->post->title;
        $this->body = $this->post->body;
        $this->images = [];
        $this->deletedImages = [];
        // Re-load images in case some were "filtered" out in the UI before canceling
        $this->existingImages = $this->post->images()->get(['id', 'name'])->toArray();
    }
}
