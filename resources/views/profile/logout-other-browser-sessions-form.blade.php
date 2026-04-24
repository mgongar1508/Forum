<x-action-section>
    <x-slot name="title">
        <span class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            {{ __('Browser Sessions') }}
        </span>
    </x-slot>

    <x-slot name="description">
        <span class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Manage and log out your active sessions on other browsers and devices.') }}
        </span>
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
        </div>

        @if (count($this->sessions) > 0)
            <div class="mt-5 space-y-4">

                @foreach ($this->sessions as $session)
                    <div
                        class="flex items-center gap-4 p-3 rounded-xl 
                                bg-gray-50 dark:bg-[#272729]">

                        <!-- ICON -->
                        <div class="text-gray-500">
                            @if ($session->agent->isDesktop())
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            @endif
                        </div>

                        <!-- SESSION INFO -->
                        <div class="flex-1">
                            <div class="text-sm text-gray-700 dark:text-gray-200">
                                {{ $session->agent->platform() ?: __('Unknown') }}
                                —
                                {{ $session->agent->browser() ?: __('Unknown') }}
                            </div>

                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $session->ip_address }},
                                @if ($session->is_current_device)
                                    <span class="text-green-500 font-medium">
                                        {{ __('This device') }}
                                    </span>
                                @else
                                    {{ __('Last active') }} {{ $session->last_active }}
                                @endif
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>
        @endif

        <!-- ACTION -->
        <div class="flex items-center mt-6">
            <button wire:click="confirmLogout" wire:loading.attr="disabled"
                class="px-4 py-2 rounded-full text-sm font-medium
                       bg-orange-500 text-white
                       hover:bg-orange-600 transition">
                {{ __('Log Out Other Browser Sessions') }}
            </button>

            <x-action-message class="ms-3 text-sm text-gray-500 dark:text-gray-400" on="loggedOut">
                {{ __('Done.') }}
            </x-action-message>
        </div>

        <!-- MODAL -->
        <x-dialog-modal wire:model.live="confirmingLogout">
            <x-slot name="title">
                <span class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    {{ __('Log Out Other Browser Sessions') }}
                </span>
            </x-slot>

            <x-slot name="content">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}
                </p>

                <div class="mt-4" x-data="{}"
                    x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">

                    <x-input type="password"
                        class="mt-1 w-full rounded-lg px-4 py-2 text-sm
                               bg-gray-100 dark:bg-[#272729]
                               border border-transparent
                               focus:outline-none focus:ring-2 focus:ring-orange-500
                               transition"
                        autocomplete="current-password" placeholder="{{ __('Password') }}" x-ref="password"
                        wire:model="password" wire:keydown.enter="logoutOtherBrowserSessions" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <button wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled"
                    class="px-4 py-2 rounded-full text-sm font-medium
                           border border-gray-300 dark:border-gray-700
                           text-gray-600 dark:text-gray-300
                           hover:bg-gray-100 dark:hover:bg-white/10 transition">
                    {{ __('Cancel') }}
                </button>

                <button wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled"
                    class="ms-3 px-4 py-2 rounded-full text-sm font-medium
                           bg-orange-500 text-white
                           hover:bg-orange-600 transition">
                    {{ __('Log Out Other Browser Sessions') }}
                </button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
