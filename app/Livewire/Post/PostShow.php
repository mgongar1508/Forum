<?php

namespace App\Livewire\Post;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PostShow extends Component
{
    public Post $post;

    public $currentImageIndex = 0;

    public function mount(Post $post)
    {
        $this->post = $post->load(['images', 'user']);
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

    public function likePost($postId, $given)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();

        PostLike::where('user_id', $userId)
            ->where('post_id', $postId)
            ->delete();

        PostLike::create([
            'user_id' => $userId,
            'post_id' => $postId,
            'type' => $given,
        ]);
    }

    public function deletePost(Post $post)
{
    $user = Auth::user();

    // Authorization
    if (! $user->hasRole('admin') && $post->user_id !== $user->id) {
        abort(403, 'Unauthorized');
    }

    // Delete images from storage + DB
    foreach ($post->images as $image) {
        Storage::disk('public')->delete($image->name);
        $image->delete();
    }

    // Delete the post
    $post->delete();
    $this->dispatch('message', 'Post deleted');
    return redirect()->route('home');
}


    public function render()
    {
        return view('livewire.post.post-show');
    }
}
