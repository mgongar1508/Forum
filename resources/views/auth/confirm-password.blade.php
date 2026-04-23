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

                <!-- DESCRIPTION -->
                <p class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
                    This is a secure area. Please confirm your password to continue.
                </p>

                <!-- ERRORS -->
                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                    @csrf

                    <!-- PASSWORD -->
                    <div>
                        <x-label for="password" value="{{ __('Password') }}"
                            class="text-sm text-gray-600 dark:text-gray-300" />

                        <x-input id="password"
                            class="mt-1 w-full rounded-lg px-4 py-2 text-sm
                                   bg-gray-100 text-black
                                   border border-transparent
                                   focus:outline-none focus:ring-2 focus:ring-orange-500
                                   transition"
                            type="password" name="password" required autofocus />
                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                        class="w-full py-2.5 rounded-full text-sm font-medium
                               bg-orange-500 text-white
                               hover:bg-orange-600 transition">
                        Confirm Password
                    </button>
                </form>

                <!-- DIVIDER -->
                <div class="my-6 border-t border-gray-200 dark:border-gray-800"></div>

                <!-- BACK -->
                <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                    Changed your mind?
                    <a href="{{ url()->previous() }}" class="text-orange-500 hover:underline">
                        Go back
                    </a>
                </p>

            </div>
        </div>
    </div>
</x-layouts.guest>
