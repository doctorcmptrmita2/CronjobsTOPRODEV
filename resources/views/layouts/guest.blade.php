<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cronjobs.to') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⚡</text></svg>">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-midnight-950 text-midnight-50 min-h-screen antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-2 mb-8">
            <div class="w-10 h-10 bg-accent-500 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-midnight-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span class="text-xl font-bold">cronjobs<span class="text-accent-500">.to</span></span>
        </a>

        <!-- Card -->
        <div class="w-full max-w-md">
            <div class="card p-8">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer -->
        <p class="mt-8 text-sm text-midnight-500">
            &copy; {{ date('Y') }} Cronjobs.to. All rights reserved.
        </p>
    </div>
</body>
</html>
