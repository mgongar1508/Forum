<x-action-section>
    <x-slot name="title">
        <span class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            {{ __('Two Factor Authentication') }}
        </span>
    </x-slot>

    <x-slot name="description">
        <span class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Add additional security to your account using two factor authentication.') }}
        </span>
    </x-slot>

    <x-slot name="content">

        <!-- STATUS -->
        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('Finish enabling two factor authentication.') }}
                @else
                    {{ __('You have enabled two factor authentication.') }}
                @endif
            @else
                {{ __('You have not enabled two factor authentication.') }}
            @endif
        </h3>

        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 max-w-xl">
            {{ __('When two factor authentication is enabled, you will be prompted for a secure token during login. You may retrieve this token from your authenticator app.') }}
        </p>

        @if ($this->enabled)

            <!-- QR / SETUP -->
            @if ($showingQrCode)

                <div class="mt-4 text-sm text-gray-600 dark:text-gray-400 max-w-xl">
                    <p class="font-semibold">
                        @if ($showingConfirmation)
                            {{ __('Scan this QR code or enter the setup key and provide the OTP code.') }}
                        @else
                            {{ __('Two factor authentication is enabled. Scan the QR code or enter the setup key.') }}
                        @endif
                    </p>
                </div>

                <div class="mt-4 p-4 inline-block bg-white dark:bg-white rounded-xl border">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>

                <div class="mt-4 text-sm text-gray-700 dark:text-gray-300">
                    <span class="font-semibold">{{ __('Setup Key') }}:</span>
                    {{ decrypt($this->user->two_factor_secret) }}
                </div>

                @if ($showingConfirmation)
                    <div class="mt-4 max-w-sm">
                        <x-label for="code" value="{{ __('Code') }}" />

                        <x-input id="code" type="text" name="code"
                            class="mt-1 w-full rounded-lg px-4 py-2 text-sm
                                   bg-gray-100
                                   border border-transparent
                                   focus:outline-none focus:ring-2 focus:ring-orange-500"
                            inputmode="numeric" autofocus autocomplete="one-time-code" wire:model="code"
                            wire:keydown.enter="confirmTwoFactorAuthentication" />

                        <x-input-error for="code" class="mt-2" />
                    </div>
                @endif
            @endif

            <!-- RECOVERY CODES -->
            @if ($showingRecoveryCodes)
                <div class="mt-4 text-sm text-gray-600 dark:text-gray-400 max-w-xl">
                    <p class="font-semibold">
                        {{ __('Store these recovery codes safely. They can be used if you lose your device.') }}
                    </p>
                </div>

                <div
                    class="mt-4 p-4 font-mono text-sm
                            bg-gray-100 dark:bg-[#272729]
                            rounded-xl border border-gray-200 dark:border-gray-800">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <!-- ACTIONS -->
        <div class="mt-6 flex flex-wrap gap-3">

            @if (!$this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <button type="button"
                        class="px-4 py-2 rounded-full text-sm font-medium
                               bg-orange-500 text-white
                               hover:bg-orange-600 transition"
                        wire:loading.attr="disabled">
                        {{ __('Enable') }}
                    </button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <button
                            class="px-4 py-2 rounded-full text-sm font-medium
                                       bg-gray-100 dark:bg-[#272729]
                                       text-gray-700 dark:text-gray-200
                                       hover:bg-gray-200 dark:hover:bg-white/10 transition
                                       me-3">
                            {{ __('Regenerate Recovery Codes') }}
                        </button>
                    </x-confirms-password>
                @elseif ($showingConfirmation)
                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <button type="button"
                            class="px-4 py-2 rounded-full text-sm font-medium
                                   bg-orange-500 text-white
                                   hover:bg-orange-600 transition me-3"
                            wire:loading.attr="disabled">
                            {{ __('Confirm') }}
                        </button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <button
                            class="px-4 py-2 rounded-full text-sm font-medium
                                       bg-gray-100 dark:bg-[#272729]
                                       text-gray-700 dark:text-gray-200
                                       hover:bg-gray-200 dark:hover:bg-white/10 transition
                                       me-3">
                            {{ __('Show Recovery Codes') }}
                        </button>
                    </x-confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <button
                            class="px-4 py-2 rounded-full text-sm font-medium
                                       bg-gray-100 dark:bg-[#272729]
                                       text-gray-700 dark:text-gray-200
                                       hover:bg-gray-200 dark:hover:bg-white/10 transition">
                            {{ __('Cancel') }}
                        </button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <button
                            class="px-4 py-2 rounded-full text-sm font-medium
                                       bg-red-500 text-white
                                       hover:bg-red-600 transition">
                            {{ __('Disable') }}
                        </button>
                    </x-confirms-password>
                @endif

            @endif
        </div>

    </x-slot>
</x-action-section>
