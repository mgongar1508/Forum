<div>
    <button
        class="sm:flex items-center gap-2 px-3 py-1.5 rounded-full
                            bg-orange-500 text-white text-sm font-medium
                            hover:bg-orange-600 transition"
        wire:click="$set('openCreate', true)">
        <i class="fas fa-add mt-0.3"></i>POST
    </button>
    <x-dialog-modal maxWidth="2xl" wire:model="openCreate">
        <x-slot name="title">
            <span class="flex items-center gap-2 text-gray-100">
                <i class="fa-solid fa-pen-to-square text-blue-400"></i>
                New Post
            </span>
        </x-slot>
        <x-slot name="content">

            {{-- TITLE --}}
            <x-label value="title" for="title" class="mb-1 text-gray-300" />
            <x-input id="title" type="text" class="w-full mb-4 bg-gray-800 text-gray-100 border-gray-700"
                placeholder="Title of the post.." wire:model="cform.title" />
            <x-input-error for="cform.title" />

            {{-- IMAGES --}}
            <div class="mb-4">
                <label for="uploadImages"
                    class="inline-flex items-center px-4 py-2 bg-gray-700 text-gray-200 rounded-lg cursor-pointer
               hover:bg-gray-600 transition border border-gray-600">
                    <i class="fa-solid fa-upload mr-2 text-blue-400"></i>
                    Select Images
                </label>

                <input id="uploadImages" type="file" multiple wire:model="cform.images" class="hidden" />

                <x-input-error for="cform.images" />
                <x-input-error for="cform.images.*" />
            </div>
            {{-- PREVIEW --}}
            @if ($cform->images)
                <div class="grid grid-cols-3 gap-4 mt-2">
                    @foreach ($cform->images as $image)
                        <div class="relative">
                            <img src="{{ $image->temporaryUrl() }}" class="rounded-lg border border-gray-700">
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- BODY --}}
            <x-label value="body" for="body" class="mb-1 text-gray-300" />
            <textarea id="body" rows="6" class="w-full rounded-lg mb-4 bg-gray-800 text-gray-100 border-gray-700"
                wire:model="cform.body" placeholder="Escribe el contenido del post..."></textarea>
            <x-input-error for="cform.body" />

            {{-- SUBFORUM --}}
            <x-label value="subforum" for="subforum" class="mb-1 text-gray-300" />
            <select id="subforum" class="w-full rounded-lg mb-4 bg-gray-800 text-gray-100 border-gray-700"
                wire:model="cform.subforum_id">
                <option value="">Select Subforum</option>
                @foreach ($subforums as $subforum)
                    <option value="{{ $subforum->id }}">{{ $subforum->name }}</option>
                @endforeach
            </select>
            <x-input-error for="cform.subforum_id" />

            <div class="grid grid-cols-6 gap-4 mb-4">
                @foreach ($tags as $tag)
                    <div class="relative" x-data="{ showTip: false }" @mouseenter="showTip = true"
                        @mouseleave="showTip = false">
                        <label for="tag_{{ $tag->id }}"
                            class="w-full flex items-start p-3 border border-gray-700 rounded-lg cursor-pointer 
                       hover:bg-gray-800 has-[:checked]:border-blue-500 has-[:checked]:bg-gray-700 
                       transition-all min-h-[48px] overflow-hidden">
                            <input type="checkbox" id="tag_{{ $tag->id }}" value="{{ $tag->id }}"
                                wire:model="cform.tags"
                                class="shrink-0 w-4 h-4 text-blue-500 bg-gray-900 border-gray-600 rounded focus:ring-blue-500">

                            <span class="ml-3 text-sm font-semibold text-gray-300 truncate block max-w-[85%]">
                                {{ $tag->name }}
                            </span>
                        </label>

                        {{-- Tooltip (always positioned above, only opacity toggles) --}}
                        <div class="absolute z-50 left-1/2 -translate-x-1/2 -top-2 -translate-y-full 
                       bg-gray-900 text-gray-200 text-xs px-3 py-1 rounded shadow-lg border border-gray-700
                       whitespace-nowrap pointer-events-none opacity-0 transition-opacity duration-150"
                            :class="{ 'opacity-100': showTip }">
                            {{ $tag->name }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- STATUS --}}
            <x-label value="Estado" for="status" class="mb-1 text-gray-300" />
            <select id="status" class="w-full rounded-lg mb-4 bg-gray-800 text-gray-100 border-gray-700"
                wire:model="cform.status">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>
        </x-slot>

        <x-slot name="footer">
            <div class="flex flex-row-reverse">

                <x-button class="bg-blue-400 hover:bg-blue-600 text-white" wire:click="create"
                    wire:loading.attr="disabled">
                    <i class="fa-solid fa-paper-plane mr-1"></i>CREATE
                </x-button>

                <x-button class="bg-red-600 hover:bg-red-700 text-white mr-2" wire:click="cancel">
                    <i class="fa-solid fa-xmark mr-1"></i>CANCEL
                </x-button>

            </div>
        </x-slot>
    </x-dialog-modal>

</div>
