<div class="py-8">
    <div class="max-w-7xl mx-auto px-4">

        <div class="grid grid-cols-12 gap-6">

            <!-- LEFT SIDEBAR -->
            <aside class="hidden lg:block col-span-2 sticky top-6 h-fit">

                <div
                    class="bg-white dark:bg-[#1a1a1b] border border-gray-200 dark:border-gray-800 rounded-2xl p-4 space-y-6 shadow-sm">

                    <div>
                        <h2 class="text-xs font-semibold uppercase text-gray-500 mb-2">
                            Navigation
                        </h2>

                        <nav class="space-y-1">

                            <a class="block px-3 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-white/10 transition">
                                Home
                            </a>

                            <a class="block px-3 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-white/10 transition">
                                Popular
                            </a>

                            <a class="block px-3 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-white/10 transition">
                                Explore
                            </a>

                        </nav>
                    </div>

                    <div>

                        <h2 class="text-xs font-semibold uppercase text-gray-500 mb-2">
                            Followed Forums
                        </h2>

                        <div class="space-y-1">

                            <a class="block px-3 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-white/10 transition">
                                r/example
                            </a>

                        </div>

                    </div>

                </div>

            </aside>


            <!-- MAIN CONTENT -->
            <main class="col-span-12 lg:col-span-7 space-y-4">

                {{ $slot }}

            </main>


            <!-- RIGHT SIDEBAR -->
            <aside class="hidden lg:block col-span-3 sticky top-6 h-fit">

                <div
                    class="bg-white dark:bg-[#1a1a1b] border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm p-4">

                    <h2 class="text-xs font-semibold uppercase text-gray-500 mb-3">
                        Latest Posts
                    </h2>

                    <div class="space-y-3 max-h-[600px] overflow-y-auto">

                        <div class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-white/10 transition">

                            <p class="text-sm font-medium">
                                Example latest post
                            </p>

                            <p class="text-xs text-gray-500">
                                r/example • 2m ago
                            </p>

                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
    <x-custom.alerta />
</div>
