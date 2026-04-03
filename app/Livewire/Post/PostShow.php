<?php

namespace App\Livewire\Post;

use App\Models\Post;
use Livewire\Component;

class PostShow extends Component
{
    public Post $post;

    public $currentImageIndex = 0;

    public function mount(Post $post)
    {
        $this->post = $post->load('images');
    }

    // Go to next image
    public function nextImage()
    {
        if ($this->currentImageIndex < $this->post->images->count() - 1) {
            $this->currentImageIndex++;
        }
    }

    // Go to previous image
    public function prevImage()
    {
        if ($this->currentImageIndex > 0) {
            $this->currentImageIndex--;
        }
    }

    public function render()
    {
        return view('livewire.post.post-show');
    }
}
