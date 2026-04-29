<x-layouts.guest>
    <div class="min-h-screen flex items-center justify-center 
                bg-gray-100 dark:bg-[#0f0f10] px-4">

        <div class="w-full max-w-md">

            <!-- CARD -->
            <div
                class="bg-white dark:bg-[#1a1a1b] 
                        border border-gray-200 dark:border-gray-800 
                        rounded-2xl shadow-lg p-8">

                <!-- LOGO -->
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('storage/images/logo/s0nus.png') }}" alt="logo" class="h-32 w-auto" />
                </div>

                <div x-data="{ recovery: false }">

                    <!-- DESCRIPTION -->
                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center" x-show="! recovery">
                        Please confirm access to your account by entering the authentication code from your app.
                    </p>

                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center" x-cloak x-show="recovery">
                        Enter one of your emergency recovery codes to continue.
                    </p>

                    <!-- ERRORS -->
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-5">
                        @csrf

                        <!-- AUTH CODE -->
                        <div x-show="! recovery">
                            <x-label for="code" value="{{ __('Code') }}"
                                class="text-sm text-gray-600 dark:text-gray-300" />

                            <x-input id="code"
                                class="mt-1 w-full rounded-lg px-4 py-2 text-sm
                                       bg-gray-100 dark:bg-[#272729]
                                       border border-transparent
                                       focus:outline-none focus:ring-2 focus:ring-orange-500
                                       transition"
                                type="text" inputmode="numeric" name="code" autofocus x-ref="code"
                                autocomplete="one-time-code" />
                        </div>

                        <!-- RECOVERY CODE -->
                        <div x-cloak x-show="recovery">
                            <x-label for="recovery_code" value="{{ __('Recovery Code') }}"
                                class="text-sm text-gray-600 dark:text-gray-300" />

                            <x-input id="recovery_code"
                                class="mt-1 w-full rounded-lg px-4 py-2 text-sm
                                       bg-gray-100 dark:bg-[#272729]
                                       border border-transparent
                                       focus:outline-none focus:ring-2 focus:ring-orange-500
                                       transition"
                                type="text" name="recovery_code" x-ref="recovery_code"
                                autocomplete="one-time-code" />
                        </div>

                        <!-- ACTIONS -->
                        <div class="flex items-center justify-between pt-2">

                            <!-- TOGGLE -->
                            <button type="button"
                                class="text-sm text-gray-500 hover:text-orange-500 underline transition"
                                x-show="! recovery"
                                x-on:click="
                                    recovery = true;
                                    $nextTick(() => { $refs.recovery_code.focus() })
                                ">
                                Use a recovery code
                            </button>

                            <button type="button"
                                class="text-sm text-gray-500 hover:text-orange-500 underline transition" x-cloak
                                x-show="recovery"
                                x-on:click="
                                    recovery = false;
                                    $nextTick(() => { $refs.code.focus() })
                                ">
                                Use an authentication code
                            </button>

                            <!-- SUBMIT -->
                            <button type="submit"
                                class="ml-auto py-2 px-5 rounded-full text-sm font-medium
                                       bg-orange-500 text-white
                                       hover:bg-orange-600 transition">
                                Log in
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
