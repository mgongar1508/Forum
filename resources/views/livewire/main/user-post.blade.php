<x-custom.base>

    <!-- FILTER BAR -->
    <div class="p-2 flex gap-3 shadow-sm items-center ml-4">
        <p class="text-sm text-gray-400">Filter by:</p>

        <button wire:click="$set('filter', 'newest')"
            class="px-3 py-1 rounded-lg text-sm transition
            {{ $filter === 'newest' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
            Newest
        </button>

        <button wire:click="$set('filter', 'likes')"
            class="px-3 py-1 rounded-lg text-sm transition
            {{ $filter === 'likes' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
            Most Liked
        </button>

        <button wire:click="$set('filter', 'comments')"
            class="px-3 py-1 rounded-lg text-sm transition
            {{ $filter === 'comments' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
            Most Commented
        </button>
    </div>

    <!-- GRID OF POSTS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 px-4 mt-4">

        @foreach ($posts as $post)
            @php
                $userLike = $post->likes->firstWhere('user_id', auth()->id());
            @endphp

            <article
                class="bg-white dark:bg-[#1a1a1b] border border-gray-200 dark:border-gray-800 rounded-xl 
                hover:bg-slate-100 dark:hover:bg-white/10 p-4 shadow-sm hover:shadow-lg transition">

                <div class="text-xs text-gray-500 mb-1">
                    In <a href="{{ route('subforum.view', $post->subforum->slug) }}" class="text-blue-600 font-medium">
                        {{ $post->subforum->name }}
                    </a>
                </div>

                <a href="{{ route('post.view', $post->id) }}">
                    <h3 class="text-base font-semibold mb-2 hover:text-blue-600 transition line-clamp-2">
                        {{ $post->title }}
                    </h3>

                    @if ($post->images->isNotEmpty())
                        <img class="rounded-lg w-full h-40 object-cover"
                            src="{{ Storage::url($post->images->first()->name) }}" />
                    @else
                        <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-3">
                            {{ $post->body }}
                        </p>
                    @endif
                </a>

                <div class="flex items-center justify-between text-sm text-gray-500 mt-3">
                    <div class="flex items-center gap-2">
                        <i wire:click="likePost({{ $post->id }}, 'Like')"
                            class="fa-solid fa-arrow-up cursor-pointer hover:text-orange-600 transition 
                            {{ $userLike?->type === 'Like' ? 'text-orange-600' : '' }}"></i>

                        <span class="font-semibold">{{ $post->likes_count }}</span>

                        <i wire:click="likePost({{ $post->id }}, 'Dislike')"
                            class="fa-solid fa-arrow-down cursor-pointer hover:text-blue-600 transition 
                            {{ $userLike?->type === 'Dislike' ? 'text-blue-600' : '' }}"></i>

                        <span class="font-semibold">{{ $post->dislikes_count }}</span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-1 mt-2">
                    @foreach ($post->tags as $tag)
                        <span class="text-xs px-2 py-0.5 rounded-full border"
                            style="color: {{ $tag->color }}; border-color: {{ $tag->color }};">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>

            </article>
        @endforeach

    </div>

    <!-- INFINITE SCROLL -->
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
