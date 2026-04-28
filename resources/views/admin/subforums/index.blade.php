<x-layouts.app>
    <x-custom.base>

        <div class="max-w-3xl mx-auto p-6">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-xl font-semibold">Subforums</h1>
                <a href="{{ route('subforums.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    + New Subforum
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-600 text-white rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <table class="w-full text-sm border border-gray-700 rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Description</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-gray-900 text-gray-200">
                    @foreach ($subforums as $subforum)
                        <tr class="border-t border-gray-700">
                            <td class="p-3">{{ $subforum->name }}</td>
                            <td class="p-3 text-gray-400">{{ $subforum->description }}</td>

                            <td class="p-3 text-right flex justify-end gap-2">

                                <a href="{{ route('subforums.edit', $subforum) }}"
                                    class="px-3 py-1 bg-yellow-500 text-black rounded hover:bg-yellow-600">
                                    Edit
                                </a>

                                <form action="{{ route('subforums.destroy', $subforum) }}" method="POST"
                                    onsubmit="return confirm('Delete this subforum?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </x-custom.base>
</x-layouts.app>
