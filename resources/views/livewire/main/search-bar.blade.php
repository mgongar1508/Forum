<div class="flex-1 max-w-xl px-4">
    <form wire:submit.prevent="search" class="w-full">
        <div class="relative w-full">

            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>

            <input wire:model="query" type="text" placeholder="Search..."
                class="w-full pl-9 pr-4 py-2 text-sm rounded-full
                            bg-gray-100 dark:bg-[#272729]
                            focus:outline-none focus:ring-2 focus:ring-orange-500
                            transition" />
        </div>
    </form>
</div>

