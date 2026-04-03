<x-custom.base>
    <div class="p-2 flex gap-3 shadow-sm">
        <p>Filter by:</p>
    </div>

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

            <div class="flex items-center gap-6 text-sm text-gray-500">

                <button wire:click="likePost({{ $post->id }}, 'Like')"
                    class="hover:text-red-500 transition transform hover:scale-110 {{ $userLike?->type === 'Like' ? 'text-red-500' : '' }}">
                    ▲ {{ $likes }}
                </button>

                <button wire:click="likePost({{ $post->id }}, 'Dislike')"
                    class="hover:text-blue-600 transition transform hover:scale-110 {{ $userLike?->type === 'Dislike' ? 'text-blue-600' : '' }}">
                    ▼ {{ $dislikes }}
                </button>

                @foreach ($post->tags as $tag)
                    <button class="rounded transition" style="color: {{ $tag->color }};">
                        {{ $tag->name }}
                    </button>
                @endforeach
            </div>
        </article>
    @endforeach

</x-custom.base>
