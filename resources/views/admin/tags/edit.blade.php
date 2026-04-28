<x-layouts.app>
    <x-custom.base>

        <div class="max-w-md mx-auto p-6">

            <h1 class="text-xl font-semibold mb-4">Edit Tag</h1>

            <form action="{{ route('tags.update', $tag) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-1">Name</label>
                    <input type="text" name="name" value="{{ $tag->name }}"
                        class="w-full px-3 py-2 rounded bg-gray-800 border border-gray-700 text-white" required>
                </div>

                <div>
                    <label class="block mb-1">Color</label>
                    <input type="color" name="color" value="{{ $tag->color }}"
                        class="w-full rounded bg-gray-800 border border-gray-700 text-white" required>
                </div>

                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update
                </button>
            </form>

        </div>

    </x-custom.base>
</x-layouts.app>
