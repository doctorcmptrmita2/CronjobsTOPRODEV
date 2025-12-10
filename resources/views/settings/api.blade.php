<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-midnight-50">API Keys</h1>
        <p class="text-sm text-midnight-400 mt-1">Manage your API access tokens</p>
    </x-slot>

    <div class="max-w-2xl">
        <div class="card p-6">
            @if(session('new_token'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-emerald-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="flex-1">
                        <p class="text-emerald-400 font-medium mb-2">API Key Generated</p>
                        <p class="text-sm text-midnight-400 mb-3">Make sure to copy your API key now. You won't be able to see it again!</p>
                        <div class="flex items-center gap-2">
                            <code class="flex-1 px-4 py-2 bg-midnight-950 rounded-lg text-sm font-mono text-midnight-100 select-all">{{ session('new_token') }}</code>
                            <button onclick="navigator.clipboard.writeText('{{ session('new_token') }}')" class="btn-secondary text-sm px-3">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($token)
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-midnight-100 font-medium">{{ $token->name }}</p>
                    <p class="text-sm text-midnight-500 mt-1">
                        Created {{ $token->created_at->diffForHumans() }}
                        @if($token->last_used_at)
                        • Last used {{ $token->last_used_at->diffForHumans() }}
                        @endif
                    </p>
                </div>
                <form action="{{ route('settings.api.regenerate') }}" method="POST" onsubmit="return confirm('Are you sure? This will invalidate your current API key.')">
                    @csrf
                    <button type="submit" class="btn-danger text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Regenerate Key
                    </button>
                </form>
            </div>
            @else
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-midnight-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-midnight-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <p class="text-midnight-400 mb-6">You don't have an API key yet.</p>
                <form action="{{ route('settings.api.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Generate API Key
                    </button>
                </form>
            </div>
            @endif
        </div>

        <!-- API Docs Preview -->
        <div class="card p-6 mt-6">
            <h3 class="text-lg font-semibold text-midnight-50 mb-4">API Usage</h3>
            <p class="text-sm text-midnight-400 mb-4">Include your API key in the Authorization header:</p>
            <pre class="bg-midnight-950 rounded-lg p-4 overflow-x-auto text-sm">
<code class="text-midnight-300"><span class="text-emerald-400">curl</span> <span class="text-accent-400">-H</span> <span class="text-blue-400">"Authorization: Bearer YOUR_API_KEY"</span> \
     https://cronjobs.to/api/v1/jobs</code>
            </pre>
        </div>
    </div>
</x-app-layout>
