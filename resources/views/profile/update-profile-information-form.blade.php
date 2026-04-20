<x-form-section submit="updateProfileInformation">

    <x-slot name="title">
        <span class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            {{ __('Profile Information') }}
        </span>
    </x-slot>

    <x-slot name="description">
        <span class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Update your account profile information and email address.') }}
        </span>
    </x-slot>

    <x-slot name="form">

        <!-- PROFILE PHOTO -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">

                <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo"
                    x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => photoPreview = e.target.result;
                            reader.readAsDataURL($refs.photo.files[0]);
                       " />

                <x-label for="photo" class="text-white" value="{{ __('Photo') }}" />

                <!-- CURRENT PHOTO -->
                <div class="mt-3" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                        class="rounded-full size-20 object-cover border border-gray-200 dark:border-gray-700">
                </div>

                <!-- PREVIEW -->
                <div class="mt-3" x-show="photoPreview" style="display: none;">
                    <span
                        class="block rounded-full size-20 bg-cover bg-center border border-gray-200 dark:border-gray-700"
                        x-bind:style="'background-image: url(' + photoPreview + ');'">
                    </span>
                </div>

                <!-- ACTIONS -->
                <div class="mt-3 flex items-center gap-2">

                    <button type="button"
                        class="px-4 py-2 rounded-full text-sm font-medium
                               bg-gray-100 dark:bg-[#272729]
                               text-gray-700 dark:text-gray-200
                               hover:bg-gray-200 dark:hover:bg-white/10 transition"
                        x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select Photo') }}
                    </button>

                    @if ($this->user->profile_photo_path)
                        <button type="button"
                            class="px-4 py-2 rounded-full text-sm font-medium
                                   bg-red-500 text-white
                                   hover:bg-red-600 transition"
                            wire:click="deleteProfilePhoto">
                            {{ __('Remove') }}
                        </button>
                    @endif

                </div>

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- NAME -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" class="text-white" value="{{ __('Name') }}" />

            <x-input id="name" type="text"
                class="mt-1 w-full rounded-lg px-4 py-2 text-sm
                       bg-gray-100 dark:bg-[#272729]
                       border border-transparent
                       focus:outline-none focus:ring-2 focus:ring-orange-500
                       transition"
                wire:model="state.name" required autocomplete="name" />

            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- EMAIL -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" class="text-white" value="{{ __('Email') }}" />

            <x-input id="email" type="email"
                class="mt-1 w-full rounded-lg px-4 py-2 text-sm
                       bg-gray-100 dark:bg-[#272729]
                       border border-transparent
                       focus:outline-none focus:ring-2 focus:ring-orange-500
                       transition"
                wire:model="state.email" required autocomplete="username" />

            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) &&
                    !$this->user->hasVerifiedEmail())
                <p class="text-sm mt-2 text-gray-600 dark:text-gray-400">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="text-orange-500 hover:underline"
                        wire:click.prevent="sendEmailVerification">
                        {{ __('Resend verification email') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 text-sm text-green-600">
                        {{ __('A new verification link has been sent.') }}
                    </p>
                @endif
            @endif
        </div>

    </x-slot>

    <x-slot name="actions">

        <div class="flex items-center gap-3">

            <x-action-message class="text-sm text-green-600" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <button type="submit" wire:loading.attr="disabled" wire:target="photo"
                class="px-4 py-2 rounded-full text-sm font-medium
                       bg-orange-500 text-white
                       hover:bg-orange-600 transition">
                {{ __('Save') }}
            </button>

        </div>

    </x-slot>

</x-form-section>
