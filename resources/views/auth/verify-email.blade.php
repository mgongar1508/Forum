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

                <!-- DESCRIPTION -->
                <p class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
                    Before continuing, please verify your email address by clicking the link we sent you.
                    If you didn’t receive it, we can send another.
                </p>

                <!-- STATUS -->
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 text-sm text-green-600 text-center">
                        A new verification link has been sent to your email address.
                    </div>
                @endif

                <!-- ACTIONS -->
                <div class="mt-6 space-y-4">

                    <!-- RESEND -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <button type="submit"
                            class="w-full py-2.5 rounded-full text-sm font-medium
                                   bg-orange-500 text-white
                                   hover:bg-orange-600 transition">
                            Resend Verification Email
                        </button>
                    </form>

                    <!-- SECONDARY ACTIONS -->
                    <div class="flex items-center justify-between text-sm">

                        <a href="{{ route('profile.show') }}" class="text-gray-500 hover:text-orange-500 transition">
                            Edit Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="text-gray-500 hover:text-orange-500 transition">
                                Log out
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.guest>
