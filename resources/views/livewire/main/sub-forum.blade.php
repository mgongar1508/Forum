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
    @if ($pinnedPosts->isNotEmpty())
        <div class="mt-2">
            <span class="text-yellow-500 font-bold">📌 Pinned Posts</span>
        </div>
        <div class="overflow-x-auto flex gap-2 p-2">
            @foreach ($pinnedPosts as $post)
                <div
                    class="min-w-[300px] bg-white dark:bg-[#1a1a1b] hover:bg-slate-100 dark:hover:bg-white/10 p-4 rounded-xl shadow">
                    <a href="{{ route('post.view', $post->id) }}">
                        <h3 class="font-semibold mb-2 hover:text-blue-600 transition">{{ $post->title }}</h3>

                        @if ($post->images->isNotEmpty())
                            <img class="rounded-lg" src="{{ Storage::url($post->images->first()->name) }}">
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    @endif
    <!-- POST TEMPLATE -->
    @foreach ($posts as $post)
        @php
            $likes = $post->likes->where('type', 'Like')->count();
            $dislikes = $post->likes->where('type', 'Dislike')->count();
            $userLike = $post->likes->firstWhere('user_id', auth()->id());
        @endphp

        <article
            class="bg-white dark:bg-[#1a1a1b] border border-gray-200 dark:border-gray-800 rounded-2xl hover:bg-slate-100 dark:hover:bg-white/10 p-5 my-2 shadow-sm hover:shadow-lg transition">
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
                    <span class="text-gray-200 font-semibold">{{ $likes }}</span>

                    <i wire:click="likePost({{ $post->id }}, 'Dislike')"
                        class="fa-solid fa-arrow-down cursor-pointer hover:text-blue-600 transition transform hover:scale-110 {{ $userLike?->type === 'Dislike' ? 'text-blue-600' : '' }}"></i>
                    <span class="text-gray-200 font-semibold">{{ $dislikes }}</span>

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
