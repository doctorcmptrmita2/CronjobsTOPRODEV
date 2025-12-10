@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Schedule HTTP jobs in the cloud. Monitor your cron jobs, get alerts on failures, and view detailed logs.">

    <title>{{ $title ? $title . ' - Cronjobs.to' : 'Cronjobs.to - Schedule HTTP Jobs in the Cloud' }}</title>

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
                    <a href="/#features" class="text-sm text-midnight-400 hover:text-midnight-50 transition-colors">Features</a>
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
    <footer class="border-t border-midnight-800 mt-24 bg-midnight-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <!-- Footer Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 mb-12">
                <!-- Brand -->
                <div class="col-span-2 lg:col-span-1">
                    <a href="/" class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-accent-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-midnight-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-lg font-bold">cronjobs<span class="text-accent-500">.to</span></span>
                    </a>
                    <p class="text-sm text-midnight-400 mb-4">
                        Cron jobs that just work. Schedule, monitor, and relax.
                    </p>
                    <!-- Status Badge -->
                    <a href="{{ route('system-status') }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-500/10 border border-emerald-500/30 rounded-full text-xs text-emerald-400 hover:bg-emerald-500/20 transition-colors">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                        All Systems Operational
                    </a>
                </div>

                <!-- Product -->
                <div>
                    <h4 class="text-sm font-semibold text-midnight-100 mb-4">Product</h4>
                    <ul class="space-y-3">
                        <li><a href="/#features" class="text-sm text-midnight-400 hover:text-accent-400 transition-colors">Features</a></li>
                        <li><a href="{{ route('pricing') }}" class="text-sm text-midnight-400 hover:text-accent-400 transition-colors">Pricing</a></li>
                        <li><a href="{{ route('faq') }}" class="text-sm text-midnight-400 hover:text-accent-400 transition-colors">FAQ</a></li>
                        <li><a href="{{ route('system-status') }}" class="text-sm text-midnight-400 hover:text-accent-400 transition-colors">System Status</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="text-sm font-semibold text-midnight-100 mb-4">Company</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('about') }}" class="text-sm text-midnight-400 hover:text-accent-400 transition-colors">About</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm text-midnight-400 hover:text-accent-400 transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="text-sm font-semibold text-midnight-100 mb-4">Legal</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('privacy') }}" class="text-sm text-midnight-400 hover:text-accent-400 transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="text-sm text-midnight-400 hover:text-accent-400 transition-colors">Terms of Service</a></li>
                        <li><a href="{{ route('contact') }}?type=abuse" class="text-sm text-midnight-400 hover:text-accent-400 transition-colors">Report Abuse</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t border-midnight-800 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-midnight-500">
                    &copy; {{ date('Y') }} Cronjobs.to. All rights reserved.
                </p>
                <div class="flex items-center gap-6">
                    <!-- Social Links -->
                    <a href="https://twitter.com/cronjobsto" target="_blank" class="text-midnight-500 hover:text-accent-400 transition-colors" title="Twitter">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                    <a href="https://github.com/cronjobsto" target="_blank" class="text-midnight-500 hover:text-accent-400 transition-colors" title="GitHub">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

