<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body
    class="font-sans antialiased
             bg-gray-100 dark:bg-[#0f0f10]
             text-gray-900 dark:text-gray-100">

    <div class="min-h-screen flex flex-col">

        <!-- OPTIONAL: You can uncomment if you want navbar on guest pages -->
        {{-- <x-custom.navbar /> --}}

        <main class="flex-1 flex items-center justify-center px-4 py-12">

            <div class="w-full">
                {{ $slot }}
            </div>

        </main>

    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>
