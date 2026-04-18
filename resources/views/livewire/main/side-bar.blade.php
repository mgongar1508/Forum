<!-- SIDEBAR -->
<aside class="fixed top-[3.5rem] left-0 z-49 w-64 h-[calc(100vh-3.5rem)]">

    <div
        class="bg-white dark:bg-[#1a1a1b] border border-gray-200 dark:border-gray-800 p-4 space-y-6 shadow-sm h-full">

        <div>
            <h2 class="text-xs font-semibold uppercase text-gray-500 mb-2">
                Navigation
            </h2>

            <nav class="space-y-1">
                <a href="/" class="block px-3 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-white/10 transition">
                    Home
                </a>
            </nav>
        </div>

        <div>
            <h2 class="text-xs font-semibold uppercase text-gray-500 mb-2">
                Followed Forums
            </h2>

            <div class="space-y-1">
                @foreach ($followed as $item)
                    <a class="block px-3 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-white/10 transition">
                        {{ $item->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div>
            <h2 class="text-xs font-semibold uppercase text-gray-500 mb-2">
                All Forums
            </h2>

            <div class="space-y-1">
                @foreach ($all as $item)
                    <a class="block px-3 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-white/10 transition">
                        {{ $item->name }}
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</aside>
