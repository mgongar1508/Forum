<x-custom.base>
    @php
        $likes = $post->likes->where('type', 'Like')->count();
        $dislikes = $post->likes->where('type', 'Dislike')->count();
        $userLike = $post->likes->firstWhere('user_id', auth()->id());
        $user = Auth::user();
    @endphp
    <div class="max-w-3xl mx-auto p-4 space-y-6 text-gray-200">

        <!-- Post Header -->
        <div class="flex items-center gap-3 text-sm text-gray-400">
            <img src="{{ Storage::url($post->user->profile_photo_path) }}" class="w-8 h-8 rounded-full" />
            <span class="font-semibold text-gray-300">{{ $post->user->name }}</span>
            <span>•</span>
            <span>{{ $post->created_at }}</span>
            @if ($user && ($user->hasRole('admin') || $user->id === $post->user_id))
                <div>
                    @livewire('post.update-post', ['postId' => $post->id], key($post->id))
                </div>
            @endif
        </div>

        <!-- Post Title -->
        <h1 class="text-2xl font-bold text-gray-100">
            {{ $post->title }}
        </h1>

        <div class="mt-4 relative w-full max-w-2xl mx-auto">
            @if ($post->images->count() > 0)
                <div class="overflow-hidden rounded-lg">
                    <img id="post-image" src="{{ Storage::url($post->images[0]->name) }}" alt="Post image"
                        class="w-full h-auto object-cover">
                </div>

                <!-- Left / Right Buttons -->
                <button id="prev-btn"
                    class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-700 bg-opacity-50 text-white px-2 py-1 rounded hover:bg-opacity-75">
                    ‹
                </button>

                <button id="next-btn"
                    class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-gray-700 bg-opacity-50 text-white px-2 py-1 rounded hover:bg-opacity-75">
                    ›
                </button>

                <!-- Counter -->
                <div id="image-counter"
                    class="absolute bottom-2 right-2 bg-gray-700 bg-opacity-50 text-white px-2 py-1 rounded text-xs">
                    1 / {{ $post->images->count() }}
                </div>

                <!-- Store image paths in a hidden element -->
                <ul id="image-list" class="hidden">
                    @foreach ($post->images as $image)
                        <li>{{ Storage::url($image->name) }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Post Body -->
        <div class="prose prose-invert max-w-none text-gray-300">
            {{ $post->body }}
        </div>

        <!-- Post Actions -->
        <div class="flex items-center gap-6 text-gray-400 text-lg">

            <!-- Upvote / Downvote -->
            <div class="flex items-center gap-2">
                <i wire:click="likePost({{ $post->id }}, 'Like')"
                    class="fa-solid fa-arrow-up cursor-pointer hover:text-red-500 transition transform hover:scale-110 {{ $userLike?->type === 'Like' ? 'text-red-500' : '' }}"></i>
                <span class="text-gray-200 font-semibold">{{ $likes }}</span>

                <i wire:click="likePost({{ $post->id }}, 'Dislike')"
                    class="fa-solid fa-arrow-down cursor-pointer hover:text-blue-600 transition transform hover:scale-110 {{ $userLike?->type === 'Dislike' ? 'text-blue-600' : '' }}"></i>
                <span class="text-gray-200 font-semibold">{{ $dislikes }}</span>
            </div>

            <!-- Share -->
            <button class="flex items-center gap-2 hover:text-gray-200">
                <i class="fa-solid fa-share"></i>
                <span class="text-sm">Share</span>
            </button>

            <!-- Save -->
            <button class="flex items-center gap-2 hover:text-gray-200">
                <i class="fa-regular fa-bookmark"></i>
                <span class="text-sm">Save</span>
            </button>

            @if ($user && ($user->hasRole('admin') || $user->id === $post->user_id))
                <button wire:click="deletePost({{ $post->id }})"
                    class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
                    <i class="fa-solid fa-trash mr-1"></i> Delete
                </button>
            @endif

        </div>

        <!-- Divider -->
        <hr class="border-gray-700" />

        <!-- Comment Input -->
        <livewire:comment.create-comment :post="$post" />

        <!-- Comments List -->
        <div class="space-y-6 mt-4">
            @foreach ($this->comments as $comment)
                <livewire:comment.comment-item :comment="$comment" :key="'comment-' . $comment->id" />
            @endforeach
        </div>
</x-custom.base>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const images = Array.from(document.querySelectorAll('#image-list li')).map(li => li.textContent);
        let currentIndex = 0;

        const imgEl = document.getElementById('post-image');
        const counterEl = document.getElementById('image-counter');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');

        function updateImage() {
            imgEl.src = images[currentIndex];
            counterEl.textContent = `${currentIndex + 1} / ${images.length}`;

            // Disable buttons if at ends
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex === images.length - 1;
        }

        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateImage();
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentIndex < images.length - 1) {
                currentIndex++;
                updateImage();
            }
        });

        updateImage(); // initialize
    });
</script>
