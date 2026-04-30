@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>

    <!-- HEADER -->
    <div class="px-6 py-4 dark:bg-[#0f0f10] border-b border-gray-800 rounded-t-xl">
        <h2 class="text-lg font-semibold text-gray-100">
            {{ $title }}
        </h2>
    </div>

    <!-- CONTENT -->
    <div class="px-6 py-5 dark:bg-[#0f0f10] text-gray-300">
        {{ $content }}
    </div>

    <!-- FOOTER -->
    <div class="flex justify-end gap-3 px-6 py-4 dark:bg-[#0f0f10] border-t border-gray-800 rounded-b-xl">
        {{ $footer }}
    </div>

</x-modal>
