<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Schedule HTTP jobs in the cloud. Monitor your cron jobs, get alerts on failures, and view detailed logs.">

    <title>{{ $title ?? 'Cronjobs.to' }} - Schedule HTTP Jobs in the Cloud</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⚡</text></svg>">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-midnight-950 text-midnight-50 min-h-screen antialiased">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-midnight-950/80 backdrop-blur-xl border-b border-midnight-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-accent-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-midnight-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold">cronjobs<span class="text-accent-500">.to</span></span>
                </a>

                <!-- Nav -->
                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{ route('pricing') }}" class="text-sm text-midnight-400 hover:text-midnight-50 transition-colors">Pricing</a>
                    <a href="#features" class="text-sm text-midnight-400 hover:text-midnight-50 transition-colors">Features</a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="btn-secondary text-sm">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="text-sm text-midnight-400 hover:text-midnight-50 transition-colors">Sign in</a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm">Get Started</a>
                    @endauth
                </nav>

                <!-- Mobile menu button -->
                <button class="md:hidden p-2 text-midnight-400 hover:text-midnight-50">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="border-t border-midnight-800 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 bg-accent-500 rounded flex items-center justify-center">
                        <svg class="w-4 h-4 text-midnight-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold">cronjobs<span class="text-accent-500">.to</span></span>
                </div>
                <p class="text-sm text-midnight-500">
                    &copy; {{ date('Y') }} Cronjobs.to. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
