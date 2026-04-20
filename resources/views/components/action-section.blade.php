<div {{ $attributes->merge([
    'class' => 'md:grid md:grid-cols-3 md:gap-6',
]) }}>

    <!-- TITLE -->
    <x-section-title>
        <x-slot name="title">
            <span class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                {{ $title }}
            </span>
        </x-slot>

        <x-slot name="description">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ $description }}
            </span>
        </x-slot>
    </x-section-title>

    <!-- CONTENT -->
    <div class="mt-5 md:mt-0 md:col-span-2">

        <div
            class="px-6 py-6
                    bg-white dark:bg-[#1a1a1b]
                    border border-gray-200 dark:border-gray-800
                    shadow-sm
                    sm:rounded-2xl">

            {{ $content }}

        </div>

    </div>
</div>
