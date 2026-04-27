<x-custom.base>

    <div class="p-4">
        <h2 class="text-xl font-semibold mb-2">
            Search results: <span class="text-blue-500">{{ $q }}</span>
        </h2>
    </div>

    @forelse ($posts as $post)
        @php
            $userLike = $post->likes->firstWhere('user_id', auth()->id());
            $thumb = $post->images->first();
        @endphp

        <a href="{{ route('post.view', $post->id) }}"
            class="flex items-start gap-3 px-4 py-3
              border-b border-gray-200 dark:border-gray-800
              hover:bg-gray-100 dark:hover:bg-white/5 transition">

            <!-- Thumbnail -->
            @if ($thumb)
                <img src="{{ Storage::url($thumb->name) }}" class="w-14 h-14 object-cover rounded-md flex-shrink-0" />
            @else
                <div
                    class="w-14 h-14 rounded-md bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-400 text-xs">
                    No Img
                </div>
            @endif

            <!-- Content -->
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <span class="text-blue-600 font-medium">
                        {{ $post->subforum->name }}
                    </span>
                    •
                    <span>{{ $post->user->name }}</span>
                </div>

                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 leading-tight line-clamp-2">
                    {{ $post->title }}
                </h3>

                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1 mt-1">
                    {{ Str::limit($post->body, 120) }}
                </p>

                <div class="flex items-center gap-4 text-xs text-gray-500 mt-2">
                    <span class="flex items-center gap-1">
                        <i class="fa-solid fa-arrow-up {{ $userLike?->type === 'Like' ? 'text-orange-600' : '' }}"></i>
                        {{ $post->likes_count }}
                    </span>

                    <span class="flex items-center gap-1">
                        <i
                            class="fa-solid fa-arrow-down {{ $userLike?->type === 'Dislike' ? 'text-blue-600' : '' }}"></i>
                        {{ $post->dislikes_count }}
                    </span>

                    <span class="flex items-center gap-1">
                        <i class="fa-regular fa-comments"></i>
                        {{ $post->comments_count }}
                    </span>
                </div>
            </div>

        </a>
    @empty
        <p class="text-center text-gray-400 mt-6">No results found</p>
    @endforelse

    <div x-data="{
        init() {
            let observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        @this.call('loadMore');
                    }
                });
            });
            observer.observe(this.$el);
        }
    }" class="h-10">
    </div>

</x-custom.base>
