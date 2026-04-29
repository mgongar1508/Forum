<x-layouts.app>
    <x-custom.base>

        <div class="max-w-4xl mx-auto p-6">

            <h1 class="text-xl font-semibold mb-6">User Management</h1>

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-600 text-white rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3 bg-red-600 text-white rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <table class="w-full text-sm border border-gray-700 rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="p-3 text-left">User</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Roles</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-gray-900 text-gray-200">
                    @foreach ($users as $user)
                        <tr class="border-t border-gray-700">

                            <td class="p-3 font-semibold">{{ $user->name }}</td>
                            <td class="p-3 text-gray-400">{{ $user->email }}</td>

                            <td class="p-3">
                                <form action="{{ route('admin.users.roles', $user) }}" method="POST"
                                    class="flex flex-wrap gap-3">
                                    @csrf
                                    @method('PUT')

                                    @foreach ($roles as $role)
                                        <label class="flex items-center gap-1">
                                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                class="rounded bg-gray-800 border-gray-600"
                                                {{ $user->roles->contains('name', $role->name) ? 'checked' : '' }}>
                                            <span>{{ $role->name }}</span>
                                        </label>
                                    @endforeach

                                    <button class="ml-3 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Save
                                    </button>
                                </form>
                            </td>

                            <td class="p-3 text-right">

                                @if (auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-500 text-xs">You</span>
                                @endif

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </x-custom.base>
</x-layouts.app>
