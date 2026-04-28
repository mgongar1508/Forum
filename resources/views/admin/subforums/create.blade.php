<x-layouts.app>
    <x-custom.base>

        <div class="max-w-md mx-auto p-6">

            <h1 class="text-xl font-semibold mb-4">Create Subforum</h1>

            <form action="{{ route('subforums.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block mb-1">Name</label>
                    <input type="text" name="name"
                        class="w-full px-3 py-2 rounded bg-gray-800 border border-gray-700 text-white" required>
                </div>

                <div>
                    <label class="block mb-1">Description</label>
                    <textarea name="description" class="w-full px-3 py-2 rounded bg-gray-800 border border-gray-700 text-white"
                        rows="3"></textarea>
                </div>

                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Create
                </button>
            </form>

        </div>

    </x-custom.base>
</x-layouts.app>
