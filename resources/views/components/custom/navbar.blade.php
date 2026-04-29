<nav class="sticky top-0 z-50 bg-white dark:bg-[#1a1a1b] border-b border-gray-200 dark:border-gray-800 overflow-visible">

    <div class="max-w-7xl mx-auto px-4">

        <div class="flex items-center justify-between h-14">

            <!-- LEFT: LOGO -->
            <div class="flex items-center gap-6">

                <a href="/" class="flex items-center gap-2 font-bold text-lg">
                    <img src="{{ asset('storage/images/logo/s0nus.png') }}" alt="logo" class="h-32 w-auto" />
                </a>

            </div>

            <!-- CENTER: SEARCH -->
            <livewire:main.search-bar />

            @role('admin')
                <div class="relative inline-block">

                    <!-- BUTTON -->
                    <button id="adminMenuBtn"
                        class="flex items-center gap-2 px-2 py-1 rounded-lg
               hover:bg-gray-100 dark:hover:bg-white/10 transition text-sm">

                        <i class="fa-solid fa-shield-halved text-orange-500"></i>
                        <span class="hidden md:block">Admin</span>
                        <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                    </button>

                    <!-- DROPDOWN -->
                    <div id="adminMenu"
                        class="hidden absolute right-0 top-full mt-2 w-48 z-50
               bg-white dark:bg-[#1a1a1b]
               border border-gray-200 dark:border-gray-800
               rounded-xl shadow-lg overflow-hidden">

                        <a href="{{ route('tags.index') }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-white/10">
                            Manage Tags
                        </a>

                        <a href="{{ route('subforums.index') }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-white/10">
                            Manage Subforums
                        </a>

                        <a href="{{ route('admin.users.index')}}"
                            class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-white/10">
                            Manage Users
                        </a>
                    </div>
                </div>
            @endrole

            <!-- RIGHT SIDE -->
            <div class="flex items-center gap-4">
                @auth

                    <!-- CREATE POST -->
                    @livewire('post.create-post')

                    <!-- USER DROPDOWN -->
                    <div class="relative inline-block">

                        <!-- BUTTON -->
                        <button id="userMenuBtn"
                            class="flex items-center gap-2 px-2 py-1 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10 transition">

                            <div class="w-8 h-8 rounded-full">
                                <img class="w-8 h-8 rounded-full"
                                    src="{{ Storage::url(Auth::user()->profile_photo_path) }}"></img>
                            </div>

                            <span class="hidden md:block text-sm">
                                {{ Auth::user()->name }}
                            </span>

                            <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                        </button>

                        <!-- DROPDOWN -->
                        <div id="userMenu"
                            class="hidden absolute right-0 top-full mt-2 w-48 z-50
               bg-white dark:bg-[#1a1a1b]
               border border-gray-200 dark:border-gray-800
               rounded-xl shadow-lg">

                            <a href="{{ route('profile.show') }}"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-white/10">
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-white/10">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                @endauth
                @guest

                    <a href="{{ route('login') }}"
                        class="px-4 py-1.5 text-sm font-medium rounded-full
                                border border-gray-300 dark:border-gray-700
                                hover:bg-gray-100 dark:hover:bg-white/10 transition">
                        Log in
                    </a>

                    <a href="{{ route('register') }}"
                        class="px-4 py-1.5 text-sm font-medium rounded-full
                        bg-orange-500 text-white hover:bg-orange-600 transition">
                        Sign up
                    </a>

                @endguest
            </div>
        </div>
    </div>
</nav>
<script>
    const btn = document.getElementById('userMenuBtn');
    const menu = document.getElementById('userMenu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!btn.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });

    //admin dropmenu
    const adminBtn = document.getElementById('adminMenuBtn');
    const adminMenu = document.getElementById('adminMenu');

    adminBtn?.addEventListener('click', () => {
        adminMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!adminBtn?.contains(e.target) && !adminMenu?.contains(e.target)) {
            adminMenu?.classList.add('hidden');
        }
    });
</script>
