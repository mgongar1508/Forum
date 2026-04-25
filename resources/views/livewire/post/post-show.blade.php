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
            <span>•</span>
            <span class="text-blue-600 font-medium"><a href="{{ route('subforum.view', $post->subforum->slug) }}">
                    {{ $post->subforum->name }}
                </a></span>
            @if ($user && ($user->hasRole('admin') || $user->id === $post->user_id))
                <div>
                    @livewire('post.update-post', ['postId' => $post->id], key($post->id))
                </div>
            @endif
            @if ($user && $user->hasAnyRole(['admin', 'moderator']))
                <button wire:click="togglePin({{ $post->id }})"
                    class="px-3 py-1.5 rounded-lg text-sm flex items-center gap-2
                    {{ $post->is_pinned ? 'bg-yellow-500 hover:bg-yellow-600 text-black' : 'bg-gray-600 hover:bg-gray-700 text-white' }}">

                    <i class="fa-solid fa-thumbtack"></i>
                    {{ $post->is_pinned ? 'Unpin' : 'Pin' }}
                </button>
                <button wire:click="toggleLock({{ $post->id }})"
                    class="px-2 py-1.5 rounded-lg text-sm flex items-center gap-2
                    {{ $post->is_locked ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-gray-600 hover:bg-gray-700 text-white' }}">

                    <i class="fa-solid fa-ban"></i>
                    {{ $post->is_locked ? 'Unblock' : 'Block' }}
                </button>
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
                        class="w-full h-auto object-cover cursor-pointer">
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
            <button onclick="sharePost('{{ route('post.view', $post->id) }}', this)"
                class="relative flex items-center gap-2 hover:text-gray-200">

                <i class="fa-solid fa-share"></i>
                <span class="text-sm">Share</span>

                <!-- Copied indicator -->
                <span
                    class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs text-green-400 opacity-0 transition-opacity duration-300 pointer-events-none">
                    Copied
                </span>
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
        @if (!$post->is_locked)
            <livewire:comment.create-comment :post="$post" />
        @else
            <div class="p-4 bg-red-900/40 border border-red-700 rounded-lg text-red-300 text-sm">
                Comments are disabled for this post.
            </div>
        @endif

        <!-- Comments List -->
        <div class="space-y-6 mt-4">
            @foreach ($this->comments as $comment)
                <livewire:comment.comment-item :comment="$comment" :key="'comment-' . $comment->id . '-' . $commentsVersion" />
            @endforeach
        </div>
        <!-- Image Modal -->
        <div id="image-modal" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50">
            <div class="relative max-w-5xl w-full px-4">

                <!-- Close Button -->
                <button id="modal-close"
                    class="absolute top-2 right-2 text-white text-2xl bg-black bg-opacity-50 rounded-full w-10 h-10">
                    ✕
                </button>

                <!-- Image -->
                <img id="modal-image" class="w-full max-h-[85vh] object-contain rounded-lg" />

                <!-- Navigation -->
                <button id="modal-prev"
                    class="absolute left-2 top-1/2 -translate-y-1/2 text-white text-3xl bg-black bg-opacity-50 px-3 py-1 rounded">
                    ‹
                </button>

                <button id="modal-next"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-white text-3xl bg-black bg-opacity-50 px-3 py-1 rounded">
                    ›
                </button>

                <!-- Counter -->
                <div id="modal-counter"
                    class="absolute bottom-3 right-3 text-white bg-black bg-opacity-50 px-2 py-1 rounded text-sm">
                </div>

            </div>
        </div>
</x-custom.base>
<script>
    function sharePost(url, btn) {
        navigator.clipboard.writeText(url);

        const label = btn.querySelector('span:last-child');

        label.classList.remove('opacity-0');
        label.classList.add('opacity-100');

        setTimeout(() => {
            label.classList.add('opacity-0');
            label.classList.remove('opacity-100');
        }, 1200);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const images = Array.from(document.querySelectorAll('#image-list li')).map(li => li.textContent);

        let currentIndex = 0;

        // Main elements
        const imgEl = document.getElementById('post-image');
        const counterEl = document.getElementById('image-counter');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');

        // Modal elements
        const modal = document.getElementById('image-modal');
        const modalImg = document.getElementById('modal-image');
        const modalCounter = document.getElementById('modal-counter');
        const modalPrev = document.getElementById('modal-prev');
        const modalNext = document.getElementById('modal-next');
        const modalClose = document.getElementById('modal-close');

        const hasMultiple = images.length > 1;

        function render() {
            const src = images[currentIndex];

            // Sync both views
            imgEl.src = src;
            modalImg.src = src;

            counterEl.textContent = `${currentIndex + 1} / ${images.length}`;
            modalCounter.textContent = `${currentIndex + 1} / ${images.length}`;

            // Buttons
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex === images.length - 1;

            modalPrev.style.display = hasMultiple ? 'block' : 'none';
            modalNext.style.display = hasMultiple ? 'block' : 'none';

            if (!hasMultiple) {
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'none';
                counterEl.style.display = 'none';
                modalCounter.style.display = 'none';
            }
        }

        function setIndex(index) {
            currentIndex = index;
            render();
        }

        // MAIN navigation
        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) setIndex(currentIndex - 1);
        });

        nextBtn.addEventListener('click', () => {
            if (currentIndex < images.length - 1) setIndex(currentIndex + 1);
        });

        // OPEN MODAL
        imgEl.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            render(); // ensure sync when opening
        });

        // MODAL navigation (same state!)
        modalPrev.addEventListener('click', () => {
            if (currentIndex > 0) setIndex(currentIndex - 1);
        });

        modalNext.addEventListener('click', () => {
            if (currentIndex < images.length - 1) setIndex(currentIndex + 1);
        });

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        modalClose.addEventListener('click', closeModal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });

        // init
        render();
    });
</script>
