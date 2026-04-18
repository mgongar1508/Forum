<!-- SIDEBAR -->
<div id="sidebarWrapper" class="fixed top-[3.5rem] left-0 h-[calc(100vh-3.5rem)] z-40">
    <aside id="sidebar"
        class="w-64 h-full bg-white dark:bg-[#1a1a1b]
           border border-gray-200 dark:border-gray-800 shadow-sm
           transform transition-transform duration-300 ease-in-out">

        <button id="sidebarToggle"
            class="absolute top-20 left-full z-50 
    -ml-4 bg-orange-600 text-white p-2 rounded-full shadow
    hover:bg-orange-700 transition-all duration-300">
            <i id="sidebarIcon" class="fa-solid fa-chevron-left"></i>
        </button>

        <div
            class="bg-white dark:bg-[#1a1a1b] border border-gray-200 dark:border-gray-800 p-4 space-y-6 shadow-sm h-full">

            <div>
                <h2 class="text-xs font-semibold uppercase text-gray-500 mb-2">
                    Navigation
                </h2>

                <nav class="space-y-1">
                    <a href="/"
                        class="block px-3 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-white/10 transition">
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
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebar');
        const icon = document.getElementById('sidebarIcon');
        const toggleBtn = document.getElementById('sidebarToggle');

        let open = true;

        toggleBtn.addEventListener('click', () => {
            open = !open;

            // Toggle the sidebar position
            sidebar.classList.toggle('-translate-x-full');

            // Update the icon
            if (open) {
                icon.classList.replace('fa-chevron-right', 'fa-chevron-left');
            } else {
                icon.classList.replace('fa-chevron-left', 'fa-chevron-right');
            }
        });
    });
</script>
