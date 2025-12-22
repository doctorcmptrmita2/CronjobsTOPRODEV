<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="/" class="inline-flex items-center gap-2 text-2xl font-bold text-midnight-50">
                    <div class="w-10 h-10 bg-gradient-to-br from-accent-400 to-accent-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-midnight-950" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span>cronjobs.to</span>
                </a>
            </div>

            <!-- Card -->
            <div class="card p-8">
                <div class="text-center mb-6">
                    <div class="w-14 h-14 bg-accent-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-midnight-50">Two-Factor Authentication</h1>
                    <p class="text-midnight-400 mt-2">Enter the code from your authenticator app</p>
                </div>

                @if(session('error'))
                <div class="mb-4 p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
                    <p class="text-sm text-red-400">{{ session('error') }}</p>
                </div>
                @endif

                <form method="POST" action="{{ route('two-factor.verify') }}">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="code" class="label">Authentication Code</label>
                        <input type="text" name="code" id="code" 
                               class="input text-center text-2xl tracking-widest font-mono @error('code') input-error @enderror"
                               placeholder="000000"
                               maxlength="21"
                               autocomplete="one-time-code"
                               autofocus>
                        <p class="mt-2 text-xs text-midnight-500">
                            You can also use a recovery code
                        </p>
                        @error('code')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full">
                        Verify
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-midnight-400 hover:text-midnight-200 transition-colors">
                        ← Back to login
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>


