<x-custom.base>
    <div class="p-2 flex gap-3 shadow-sm items-center">

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

    <!-- POST TEMPLATE -->
    @foreach ($posts as $post)
        @php
            $userLike = $post->likes->firstWhere('user_id', auth()->id());
        @endphp

        <article
            class="bg-white dark:bg-[#1a1a1b] border border-gray-200 dark:border-gray-800 rounded-2xl hover:bg-slate-100 dark:hover:bg-white/10 p-5 my-2 mx-2 shadow-sm hover:shadow-lg transition">
            <div class="text-sm text-gray-500 mb-2">
                Posted in <span class="text-blue-600 font-medium"><a
                        href="{{ route('subforum.view', $post->subforum->slug) }}">
                        {{ $post->subforum->name }}
                    </a></span>
                • by {{ $post->user->name }}
            </div>

            <a href="{{ route('post.view', $post->id) }}">
                <div>
                    <h3 class="text-lg font-semibold mb-2 hover:text-blue-600 transition">
                        {{ $post->title }}
                    </h3>

                    @if ($post->images->isNotEmpty())
                        <div class="mb-4 relative w-full max-w-2xl mx-auto">
                            <img class="rounded-xl " src="{{ Storage::url($post->images->first()->name) }}" />
                        </div>
                    @else
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                            {{ $post->body }}
                        </p>
                    @endif
                </div>
            </a>

            <div class="flex items-center justify-between text-sm text-gray-500">
                <div class="flex items-center gap-2">
                    <i wire:click="likePost({{ $post->id }}, 'Like')"
                        class="fa-solid fa-arrow-up cursor-pointer hover:text-orange-600 transition transform hover:scale-110 {{ $userLike?->type === 'Like' ? 'text-orange-600' : '' }}"></i>
                    <span class="text-gray-200 font-semibold">{{ $post->likes_count }}</span>

                    <i wire:click="likePost({{ $post->id }}, 'Dislike')"
                        class="fa-solid fa-arrow-down cursor-pointer hover:text-blue-600 transition transform hover:scale-110 {{ $userLike?->type === 'Dislike' ? 'text-blue-600' : '' }}"></i>

                    <span class="text-gray-200 font-semibold">{{ $post->dislikes_count }}</span>

                    <div class="ml-6 flex gap-2">
                        @foreach ($post->tags as $tag)
                            <button class="rounded transition" style="color: {{ $tag->color }};">
                                {{ $tag->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

        </article>
    @endforeach
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
