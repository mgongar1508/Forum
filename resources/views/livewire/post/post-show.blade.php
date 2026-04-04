<x-custom.base>
    @php
        $likes = $post->likes->where('type', 'Like')->count();
        $dislikes = $post->likes->where('type', 'Dislike')->count();
        $userLike = $post->likes->firstWhere('user_id', auth()->id());
    @endphp
    <div class="max-w-3xl mx-auto p-4 space-y-6 text-gray-200">

        <!-- Post Header -->
        <div class="flex items-center gap-3 text-sm text-gray-400">
            <img src="{{ Storage::url($post->user->profile_photo_path) }}" class="w-8 h-8 rounded-full" />
            <span class="font-semibold text-gray-300">{{ $post->user->name }}</span>
            <span>•</span>
            <span>{{ $post->created_at }}</span>
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

            @if (auth()->user()->hasRole('admin') || auth()->id() === $post->user_id)
                <button wire:click="deletePost({{ $post->id }})"
                    class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
                    <i class="fa-solid fa-trash mr-1"></i> Delete
                </button>
            @endif

        </div>

        <!-- Divider -->
        <hr class="border-gray-700" />

        <!-- Comment Input -->
        <div class="flex gap-3">
            <input type="text" placeholder="Add a comment..."
                class="flex-1 bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-gray-200 placeholder-gray-500 focus:ring focus:ring-blue-500" />
        </div>

        <!-- Comments List -->
        <div class="space-y-6 mt-4">

            <!-- Single Comment -->
            <div class="flex gap-3">
                <img src="https://via.placeholder.com/32" class="w-8 h-8 rounded-full" />

                <div class="flex-1">
                    <div class="flex items-center gap-2 text-sm text-gray-400">
                        <span class="font-semibold text-gray-300">u/commenter</span>
                        <span>•</span>
                        <span>2 hours ago</span>
                    </div>

                    <p class="text-gray-200 mt-1">
                        This is a comment. It stays readable without glowing too bright.
                    </p>

                    <div class="flex items-center gap-4 text-gray-500 text-sm mt-2">
                        <i class="fa-solid fa-arrow-up cursor-pointer hover:text-orange-400"></i>
                        <i class="fa-solid fa-arrow-down cursor-pointer hover:text-blue-400"></i>

                        <button class="hover:text-gray-300 flex items-center gap-1">
                            <i class="fa-regular fa-comment"></i> Reply
                        </button>
                    </div>
                </div>
            </div>

            <div class="space-y-6 mt-4">

                <!-- Comment Level 1 -->
                <div class="flex gap-3">

                    <!-- Avatar -->
                    <img src="https://via.placeholder.com/32" class="w-8 h-8 rounded-full" />

                    <div class="flex-1">

                        <!-- Header -->
                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <span class="font-semibold text-gray-300">u/commenter1</span>
                            <span>•</span>
                            <span>3 hours ago</span>
                        </div>

                        <!-- Body -->
                        <p class="text-gray-200 mt-1">
                            This is a top-level comment. It introduces the discussion.
                        </p>

                        <!-- Actions -->
                        <div class="flex items-center gap-4 text-gray-500 text-sm mt-2">
                            <i class="fa-solid fa-arrow-up hover:text-orange-400 cursor-pointer"></i>
                            <i class="fa-solid fa-arrow-down hover:text-blue-400 cursor-pointer"></i>

                            <button class="hover:text-gray-300 flex items-center gap-1">
                                <i class="fa-regular fa-comment"></i> Reply
                            </button>
                        </div>

                        <!-- Nested Reply (compact indent) -->
                        <div class="mt-4 ml-4 border-l border-gray-700 pl-3">

                            <div class="flex gap-3">

                                <img src="https://via.placeholder.com/28" class="w-7 h-7 rounded-full" />

                                <div class="flex-1">

                                    <div class="flex items-center gap-2 text-sm text-gray-400">
                                        <span class="font-semibold text-gray-300">u/replier1</span>
                                        <span>•</span>
                                        <span>1 hour ago</span>
                                    </div>

                                    <p class="text-gray-200 mt-1">
                                        This is a nested reply, but with a much smaller indent so it stays readable.
                                    </p>

                                    <div class="flex items-center gap-4 text-gray-500 text-sm mt-2">
                                        <i class="fa-solid fa-arrow-up hover:text-orange-400 cursor-pointer"></i>
                                        <i class="fa-solid fa-arrow-down hover:text-blue-400 cursor-pointer"></i>

                                        <button class="hover:text-gray-300 flex items-center gap-1">
                                            <i class="fa-regular fa-comment"></i> Reply
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End Nested Reply -->
                    </div>
                </div>
            </div>
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
