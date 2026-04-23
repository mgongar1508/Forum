<x-action-section>
    <x-slot name="title">
        <span class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            {{ __('Delete Account') }}
        </span>
    </x-slot>

    <x-slot name="description">
        <span class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Permanently delete your account.') }}
        </span>
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </div>

        <div class="mt-5">
            <button wire:click="confirmUserDeletion" wire:loading.attr="disabled"
                class="px-4 py-2 rounded-full text-sm font-medium
                       bg-red-500 text-white
                       hover:bg-red-600 transition">
                {{ __('Delete Account') }}
            </button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                <span class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    {{ __('Delete Account') }}
                </span>
            </x-slot>

            <x-slot name="content">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="mt-4" x-data="{}"
                    x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">

                    <x-input type="password"
                        class="mt-1 w-full rounded-lg px-4 py-2 text-sm
                               bg-gray-100 text-black
                               border border-transparent
                               focus:outline-none focus:ring-2 focus:ring-red-500
                               transition"
                        autocomplete="current-password" placeholder="{{ __('Password') }}" x-ref="password"
                        wire:model="password" wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled"
                    class="px-4 py-2 rounded-full text-sm font-medium
                           border border-gray-300 dark:border-gray-700
                           text-gray-600 dark:text-gray-300
                           hover:bg-gray-100 dark:hover:bg-white/10 transition">
                    {{ __('Cancel') }}
                </button>

                <button wire:click="deleteUser" wire:loading.attr="disabled"
                    class="ms-3 px-4 py-2 rounded-full text-sm font-medium
                           bg-red-500 text-white
                           hover:bg-red-600 transition">
                    {{ __('Delete Account') }}
                </button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
