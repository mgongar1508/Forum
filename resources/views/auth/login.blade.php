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
                    <x-authentication-card-logo />
                </div>

                <!-- ERRORS -->
                <x-validation-errors class="mb-4" />

                <!-- STATUS -->
                @session('status')
                    <div class="mb-4 text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- EMAIL -->
                    <div>
                        <x-label for="email" value="{{ __('Email') }}"
                            class="text-sm text-gray-600 dark:text-gray-300" />

                        <x-input id="email"
                            class="mt-1 w-full rounded-lg px-4 py-2 text-sm
                                   bg-gray-100
                                   border border-transparent
                                   focus:outline-none focus:ring-2 focus:ring-orange-500
                                   transition"
                            type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <x-label for="password" value="{{ __('Password') }}"
                            class="text-sm text-gray-600 dark:text-gray-300" />

                        <x-input id="password"
                            class="mt-1 w-full rounded-lg px-4 py-2 text-sm
                                   bg-gray-100
                                   border border-transparent
                                   focus:outline-none focus:ring-2 focus:ring-orange-500
                                   transition"
                            type="password" name="password" required />
                    </div>

                    <!-- REMEMBER + FORGOT -->
                    <div class="flex items-center justify-between text-sm">

                        <label class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                            <x-checkbox name="remember"
                                class="rounded border-gray-300 text-orange-500 focus:ring-orange-500" />
                            Remember me
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-gray-500 hover:text-orange-500 transition">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                        class="w-full py-2.5 rounded-full text-sm font-medium
                               bg-orange-500 text-white
                               hover:bg-orange-600 transition">
                        Log in
                    </button>
                </form>

                <!-- DIVIDER -->
                <div class="my-6 border-t border-gray-200 dark:border-gray-800"></div>

                <!-- REGISTER -->
                <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="text-orange-500 hover:underline">
                        Sign up
                    </a>
                </p>

            </div>
        </div>
    </div>
</x-layouts.guest>
