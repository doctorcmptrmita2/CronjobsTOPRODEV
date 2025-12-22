<x-app-layout>
    <x-slot name="title">Telegram Settings</x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('settings.notifications') }}" class="p-2 text-midnight-400 hover:text-midnight-100 hover:bg-midnight-800 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-midnight-50">Telegram Notifications</h1>
                <p class="text-sm text-midnight-400 mt-1">Connect your Telegram account to receive instant alerts</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        @if(!$isConfigured)
        <!-- Bot not configured warning -->
        <div class="card p-6 mb-6 border-amber-500/50 bg-amber-500/5">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 text-amber-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-amber-300">Telegram Bot Not Configured</h3>
                    <p class="text-sm text-midnight-400 mt-1">
                        The Telegram bot has not been configured yet. Please contact the administrator to set up the TELEGRAM_BOT_TOKEN environment variable.
                    </p>
                </div>
            </div>
        </div>
        @endif

        @if($user->telegram_enabled && $user->telegram_chat_id)
        <!-- Connected State -->
        <div class="card p-6 mb-6 border-emerald-500/50 bg-emerald-500/5">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-emerald-500/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-emerald-300">Telegram Connected</h3>
                    <p class="text-sm text-midnight-400 mt-1">
                        Your account is connected to Telegram
                        @if($user->telegram_username)
                            (@{{ $user->telegram_username }})
                        @endif
                    </p>
                    <p class="text-xs text-midnight-500 mt-2">
                        Connected on {{ $user->telegram_verified_at->format('M d, Y \a\t H:i') }}
                    </p>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <form action="{{ route('settings.telegram.test') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn-secondary text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Send Test Message
                    </button>
                </form>
                <form action="{{ route('settings.telegram.disconnect') }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to disconnect Telegram?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Disconnect
                    </button>
                </form>
            </div>
        </div>

        <!-- What you'll receive -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-midnight-50 mb-4">📬 What You'll Receive</h3>
            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 bg-midnight-800/50 rounded-lg">
                    <div class="text-red-400">🔴</div>
                    <div>
                        <p class="text-midnight-100">Job Failure Alerts</p>
                        <p class="text-xs text-midnight-500">When a cron job fails multiple times</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-midnight-800/50 rounded-lg">
                    <div class="text-emerald-400">✅</div>
                    <div>
                        <p class="text-midnight-100">Recovery Notifications</p>
                        <p class="text-xs text-midnight-500">When a failing job or endpoint recovers</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-midnight-800/50 rounded-lg">
                    <div class="text-amber-400">⚠️</div>
                    <div>
                        <p class="text-midnight-100">Uptime Alerts</p>
                        <p class="text-xs text-midnight-500">When monitored endpoints go down</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-midnight-800/50 rounded-lg">
                    <div class="text-blue-400">🔐</div>
                    <div>
                        <p class="text-midnight-100">Security Alerts</p>
                        <p class="text-xs text-midnight-500">New login notifications (if enabled)</p>
                    </div>
                </div>
            </div>
        </div>

        @else
        <!-- Not Connected State -->
        <div class="card p-6">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-400" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-midnight-50 mb-2">Connect Telegram</h3>
                <p class="text-midnight-400">Get instant notifications directly in Telegram</p>
            </div>

            @if(session('verification_code'))
            <!-- Verification Code Display -->
            <div class="bg-midnight-800 rounded-lg p-6 mb-6">
                <h4 class="text-sm font-medium text-midnight-300 mb-3">Your Verification Code:</h4>
                <div class="flex items-center justify-center gap-2 mb-4">
                    <code class="text-3xl font-mono font-bold text-accent-400 tracking-widest">{{ session('verification_code') }}</code>
                    <button onclick="navigator.clipboard.writeText('{{ session('verification_code') }}')" class="p-2 hover:bg-midnight-700 rounded transition-colors" title="Copy code">
                        <svg class="w-5 h-5 text-midnight-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>
                <p class="text-sm text-midnight-400 text-center mb-4">
                    This code expires in 10 minutes
                </p>
                <div class="flex justify-center">
                    @if($botUsername)
                    <a href="https://t.me/{{ $botUsername }}?start={{ session('verification_code') }}" 
                       target="_blank"
                       class="btn-primary">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                        </svg>
                        Open in Telegram
                    </a>
                    @endif
                </div>
            </div>

            <div class="text-center text-sm text-midnight-400">
                <p>Or manually send this code to @{{ $botUsername ?? 'CronjobsBot' }}</p>
            </div>

            @else
            <!-- Connect Button -->
            <form action="{{ route('settings.telegram.connect') }}" method="POST" class="text-center">
                @csrf
                <button type="submit" class="btn-primary text-lg px-8 py-3" @if(!$isConfigured) disabled @endif>
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                    </svg>
                    Connect Telegram
                </button>
            </form>

            <!-- How it works -->
            <div class="mt-8 pt-8 border-t border-midnight-800">
                <h4 class="text-sm font-medium text-midnight-300 mb-4">How it works:</h4>
                <ol class="space-y-3 text-sm text-midnight-400">
                    <li class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-midnight-700 rounded-full flex items-center justify-center text-xs font-medium text-midnight-300">1</span>
                        <span>Click "Connect Telegram" to generate a verification code</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-midnight-700 rounded-full flex items-center justify-center text-xs font-medium text-midnight-300">2</span>
                        <span>Open Telegram and start a chat with our bot</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-midnight-700 rounded-full flex items-center justify-center text-xs font-medium text-midnight-300">3</span>
                        <span>Send the verification code to the bot</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-midnight-700 rounded-full flex items-center justify-center text-xs font-medium text-midnight-300">4</span>
                        <span>Start receiving instant alerts!</span>
                    </li>
                </ol>
            </div>
            @endif
        </div>
        @endif
    </div>
</x-app-layout>


