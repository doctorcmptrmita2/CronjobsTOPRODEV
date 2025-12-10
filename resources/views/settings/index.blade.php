<x-app-layout>
    <x-slot name="title">Settings</x-slot>

    <x-slot name="header">
        <h1 class="text-2xl font-bold text-midnight-50">Settings</h1>
        <p class="text-sm text-midnight-400 mt-1">Manage your account and preferences</p>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Account -->
        <a href="{{ route('settings.account') }}" class="card p-6 hover:border-midnight-700 transition-all group">
            <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-500/20 transition-colors">
                <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-midnight-100 mb-1">Account</h3>
            <p class="text-sm text-midnight-400">Update your profile information and timezone</p>
        </a>

        <!-- Notifications -->
        <a href="{{ route('settings.notifications') }}" class="card p-6 hover:border-midnight-700 transition-all group">
            <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-500/20 transition-colors">
                <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-midnight-100 mb-1">Notifications</h3>
            <p class="text-sm text-midnight-400">Configure email alerts and notification preferences</p>
        </a>

        <!-- API Keys -->
        <a href="{{ route('settings.api') }}" class="card p-6 hover:border-midnight-700 transition-all group">
            <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-emerald-500/20 transition-colors">
                <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-midnight-100 mb-1">API Keys</h3>
            <p class="text-sm text-midnight-400">Manage your API access tokens</p>
        </a>

        <!-- Plan & Billing -->
        <a href="{{ route('pricing') }}" class="card p-6 hover:border-midnight-700 transition-all group">
            <div class="w-12 h-12 bg-amber-500/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-amber-500/20 transition-colors">
                <svg class="w-6 h-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-midnight-100 mb-1">Plan & Billing</h3>
            <p class="text-sm text-midnight-400">View your current plan and upgrade options</p>
            <div class="mt-3">
                <span class="badge-neutral">{{ $user->plan?->name ?? 'Free' }} Plan</span>
            </div>
        </a>
    </div>
</x-app-layout>

