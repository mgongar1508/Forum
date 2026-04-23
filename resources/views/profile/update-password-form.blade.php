<x-form-section submit="updatePassword">

    <x-slot name="title">
        <span class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            {{ __('Update Password') }}
        </span>
    </x-slot>

    <x-slot name="description">
        <span class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </span>
    </x-slot>

    <x-slot name="form">

        <!-- CURRENT PASSWORD -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" class="text-white" value="{{ __('Current Password') }}" />

            <x-input id="current_password" type="password"
                class="mt-1 w-full rounded-lg px-4 py-2 text-sm
                       bg-gray-100 text-black
                       border border-transparent
                       focus:outline-none focus:ring-2 focus:ring-orange-500
                       transition"
                wire:model="state.current_password" autocomplete="current-password" />

            <x-input-error for="current_password" class="mt-2" />
        </div>

        <!-- NEW PASSWORD -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" class="text-white" value="{{ __('New Password') }}" />

            <x-input id="password" type="password"
                class="mt-1 w-full rounded-lg px-4 py-2 text-sm
                       bg-gray-100 text-black
                       border border-transparent
                       focus:outline-none focus:ring-2 focus:ring-orange-500
                       transition"
                wire:model="state.password" autocomplete="new-password" />

            <x-input-error for="password" class="mt-2" />
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" class="text-white" value="{{ __('Confirm Password') }}" />

            <x-input id="password_confirmation" type="password"
                class="mt-1 w-full rounded-lg px-4 py-2 text-sm
                       bg-gray-100 text-black
                       border border-transparent
                       focus:outline-none focus:ring-2 focus:ring-orange-500
                       transition"
                wire:model="state.password_confirmation" autocomplete="new-password" />

            <x-input-error for="password_confirmation" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">

        <div class="flex items-center gap-3">

            <x-action-message class="text-sm text-green-600" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <button type="submit"
                class="px-4 py-2 rounded-full text-sm font-medium
                       bg-orange-500 text-white
                       hover:bg-orange-600 transition">
                {{ __('Save') }}
            </button>

        </div>

    </x-slot>

</x-form-section>
