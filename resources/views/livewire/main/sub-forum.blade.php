<x-custom.base>
    <div class="p-4 flex justify-between items-center border-b">
        <h1 class="text-xl font-bold">{{ $subforum->name }}</h1>
        @auth
            <button wire:click="followSubforum"
                class="px-4 py-1 rounded-xl
                {{ $isFollowing ? 'bg-gray-500' : 'bg-blue-600' }} text-white">

                {{ $isFollowing ? 'Following' : 'Follow' }}
            </button>
        @endauth
    </div>
    <div class="p-2 flex gap-3 shadow-sm items-center">
        <span class="text-sm text-gray-400">Filter by:</span>

        <button wire:click="$set('filter', 'newest')"
            class="px-3 py-1 rounded-lg text-sm
        {{ $filter === 'newest' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
            Newest
        </button>

        <button wire:click="$set('filter', 'likes')"
            class="px-3 py-1 rounded-lg text-sm
        {{ $filter === 'likes' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
            Most Liked
        </button>

        <button wire:click="$set('filter', 'comments')"
            class="px-3 py-1 rounded-lg text-sm
        {{ $filter === 'comments' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
            Most Commented
        </button>
    </div>
    @if ($pinnedPosts->isNotEmpty())
        <div class="mt-2">
            <span class="text-yellow-500 font-bold">📌 Pinned Posts</span>
        </div>

        <div id="pinned-container" class="relative overflow-hidden mt-2">

            <!-- LEFT BUTTON -->
            <button id="pinned-prev"
                class="absolute left-2 top-1/2 -translate-y-1/2 z-10 
                   bg-black/40 hover:bg-black/60 text-white 
                   text-2xl px-3 py-2 rounded-full backdrop-blur-sm transition">
                ‹
            </button>

            <!-- RIGHT BUTTON -->
            <button id="pinned-next"
                class="absolute right-2 top-1/2 -translate-y-1/2 z-10 
                   bg-black/40 hover:bg-black/60 text-white 
                   text-2xl px-3 py-2 rounded-full backdrop-blur-sm transition">
                ›
            </button>

            <!-- SLIDER -->
            <div id="pinned-track" class="flex gap-4 transition-transform duration-300">
                @foreach ($pinnedPosts as $post)
                    <div
                        class="min-w-[240px] max-w-[300px] h-[240px]
                            bg-white dark:bg-[#1a1a1b]
                            hover:bg-slate-100 dark:hover:bg-white/10
                            p-3 rounded-xl shadow flex flex-col justify-between">

                        <a href="{{ route('post.view', $post->id) }}">
                            <div class="h-[38px] overflow-hidden">
                                <h3
                                    class="font-semibold leading-tight line-clamp-2 hover:text-blue-600 transition">
                                    {{ $post->title }}
                                </h3>
                            </div>
                            @if ($post->images->isNotEmpty())
                                <img class="rounded-lg w-full h-[140px] object-cover mt-2"
                                    src="{{ Storage::url($post->images->first()->name) }}">
                            @else
                                <p class="text-sm text-gray-400 line-clamp-3">
                                    {{ Str::limit(strip_tags($post->body), 100) }}
                                </p>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <!-- POST TEMPLATE -->
    @foreach ($posts as $post)
        @php
            $userLike = $post->likes->first();
        @endphp

        <article
            class="bg-white dark:bg-[#1a1a1b] border border-gray-200 dark:border-gray-800 rounded-2xl hover:bg-slate-100 dark:hover:bg-white/10 p-5 my-2 mx-2 shadow-sm hover:shadow-lg transition">
            <div class="text-sm text-gray-500 mb-2">
                Posted in <span class="text-blue-600 font-medium">{{ $post->subforum->name }}</span>
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

                {{-- LEFT SIDE --}}
                <div class="flex items-center gap-2">
                    <i wire:click="likePost({{ $post->id }}, 'Like')"
                        class="fa-solid fa-arrow-up cursor-pointer hover:text-red-500 transition transform hover:scale-110 {{ $userLike?->type === 'Like' ? 'text-red-500' : '' }}"></i>
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const track = document.getElementById('pinned-track');
        const prevBtn = document.getElementById('pinned-prev');
        const nextBtn = document.getElementById('pinned-next');

        if (!track) return;

        let scrollPosition = 0;
        const scrollAmount = 320; // width of card + gap

        function update() {
            track.style.transform = `translateX(-${scrollPosition}px)`;
        }

        nextBtn.addEventListener('click', () => {
            const maxScroll = track.scrollWidth - track.parentElement.clientWidth;

            scrollPosition = Math.min(scrollPosition + scrollAmount, maxScroll);
            update();
        });

        prevBtn.addEventListener('click', () => {
            scrollPosition = Math.max(scrollPosition - scrollAmount, 0);
            update();
        });
    });
</script>
