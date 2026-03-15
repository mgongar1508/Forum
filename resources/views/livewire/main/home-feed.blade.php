<x-custom.base>
    <!-- CREATE POST -->
    <div
        class="bg-white dark:bg-[#1a1a1b] border border-gray-200 dark:border-gray-800 p-2 rounded-xl flex gap-3 shadow-sm">

        <p>Filter by:</p>

    </div>


    <!-- POST TEMPLATE -->
    @foreach ($posts as $post)
        <article
            class="bg-white dark:bg-[#1a1a1b] border border-gray-200 dark:border-gray-800 rounded-2xl hover:bg-slate-100 dark:hover:bg-white/10 p-5 shadow-sm hover:shadow-lg transition">
            <div class="text-sm text-gray-500 mb-2">
                Posted in <span class="text-blue-600 font-medium">r/example</span>
                • by user123
            </div>

            <h3 class="text-lg font-semibold mb-2 hover:text-blue-600 transition">
                {{ $post->title }}
            </h3>

            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                {{ $post->body }}
            </p>

            <div class="flex items-center gap-6 text-sm text-gray-500">

                <button class="hover:text-blue-600 transition transform hover:scale-110">
                    ▲ 124
                </button>

                <button class="hover:text-red-500 transition transform hover:scale-110">
                    ▼ 123
                </button>

                <button class="hover:text-gray-700 dark:hover:text-gray-200 transition">
                    Comments
                </button>

            </div>
        </article>
    @endforeach

</x-custom.base>
