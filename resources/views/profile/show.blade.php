<x-layouts.app>
    <!-- KEY CHANGE: add left padding for sidebar -->
    <div class="py-8 bg-gray-100 dark:bg-[#0f0f10] min-h-screen pl-0 lg:pl-34">

        <!-- narrower content container -->
        <div class="max-w-4xl mx-auto px-4 space-y-6">

            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <div
                    class="bg-white dark:bg-[#1a1a1b]
                            border border-gray-200 dark:border-gray-800
                            rounded-2xl shadow-sm p-6">
                    @livewire('profile.update-profile-information-form')
                </div>
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div
                    class="bg-white dark:bg-[#1a1a1b]
                            border border-gray-200 dark:border-gray-800
                            rounded-2xl shadow-sm p-6">
                    @livewire('profile.update-password-form')
                </div>
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div
                    class="bg-white dark:bg-[#1a1a1b]
                            border border-gray-200 dark:border-gray-800
                            rounded-2xl shadow-sm p-6">
                    @livewire('profile.two-factor-authentication-form')
                </div>
            @endif

            <div
                class="bg-white dark:bg-[#1a1a1b]
                        border border-gray-200 dark:border-gray-800
                        rounded-2xl shadow-sm p-6">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div
                    class="bg-white dark:bg-[#1a1a1b]
                            border border-gray-200 dark:border-gray-800
                            rounded-2xl shadow-sm p-6">
                    @livewire('profile.delete-user-form')
                </div>
            @endif

        </div>
    </div>
</x-layouts.app>
