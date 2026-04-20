@props(['submit'])

<div {{ $attributes->merge([
    'class' => 'md:grid md:grid-cols-3 md:gap-6',
]) }}>

    <!-- SECTION TITLE -->
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

    <!-- FORM -->
    <div class="mt-5 md:mt-0 md:col-span-2">

        <form wire:submit="{{ $submit }}">

            <!-- BODY -->
            <div
                class="px-6 py-6
                        bg-white dark:bg-[#1a1a1b]
                        border border-gray-200 dark:border-gray-800
                        shadow-sm
                        {{ isset($actions) ? 'sm:rounded-t-2xl' : 'sm:rounded-2xl' }}">

                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>

            </div>

            <!-- ACTIONS -->
            @if (isset($actions))
                <div
                    class="flex items-center justify-end gap-3
                            px-6 py-4
                            bg-gray-50 dark:bg-[#161617]
                            border-x border-b border-gray-200 dark:border-gray-800
                            sm:rounded-b-2xl">

                    {{ $actions }}

                </div>
            @endif

        </form>

    </div>
</div>
