<x-app-layout>
    <x-slot name="title">Setup Two-Factor Authentication</x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('settings.two-factor') }}" class="p-2 text-midnight-400 hover:text-midnight-100 hover:bg-midnight-800 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-midnight-50">Setup Two-Factor Authentication</h1>
                <p class="text-sm text-midnight-400 mt-1">Scan the QR code with your authenticator app</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="card p-6">
            <!-- Step 1: Scan QR Code -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-accent-500 rounded-full flex items-center justify-center text-white font-bold text-sm">1</div>
                    <h3 class="text-lg font-semibold text-midnight-50">Scan QR Code</h3>
                </div>
                <p class="text-sm text-midnight-400 mb-6">
                    Open your authenticator app (Google Authenticator, Authy, etc.) and scan this QR code:
                </p>
                
                <div class="flex justify-center mb-6">
                    <div class="bg-white p-4 rounded-lg">
                        <img src="{{ $qrCodeUrl }}" alt="QR Code" class="w-48 h-48">
                    </div>
                </div>

                <div class="bg-midnight-800/50 rounded-lg p-4">
                    <p class="text-xs text-midnight-400 mb-2">Can't scan? Enter this code manually:</p>
                    <div class="flex items-center gap-2">
                        <code class="text-sm font-mono text-accent-400 bg-midnight-900 px-3 py-2 rounded select-all">{{ $secret }}</code>
                        <button onclick="navigator.clipboard.writeText('{{ $secret }}')" class="p-2 hover:bg-midnight-700 rounded transition-colors" title="Copy code">
                            <svg class="w-4 h-4 text-midnight-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 2: Enter Code -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-midnight-700 rounded-full flex items-center justify-center text-midnight-300 font-bold text-sm">2</div>
                    <h3 class="text-lg font-semibold text-midnight-50">Verify Code</h3>
                </div>
                <p class="text-sm text-midnight-400 mb-6">
                    Enter the 6-digit code from your authenticator app to verify the setup:
                </p>

                <form action="{{ route('settings.two-factor.enable') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="code" class="label">Verification Code</label>
                        <input type="text" name="code" id="code" 
                               class="input text-center text-2xl tracking-widest font-mono @error('code') input-error @enderror"
                               placeholder="000000"
                               maxlength="6"
                               autocomplete="one-time-code"
                               inputmode="numeric"
                               pattern="[0-9]*"
                               autofocus>
                        @error('code')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        @if(session('error'))
                        <p class="mt-1.5 text-sm text-red-400">{{ session('error') }}</p>
                        @endif
                    </div>

                    <button type="submit" class="btn-primary w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Enable Two-Factor Authentication
                    </button>
                </form>
            </div>
        </div>

        <!-- Warning -->
        <div class="mt-6 p-4 bg-amber-500/10 border border-amber-500/30 rounded-lg">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 text-amber-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-amber-300">Important</h4>
                    <p class="text-sm text-midnight-400 mt-1">
                        Make sure to save your recovery codes after enabling 2FA. You'll need them to access your account if you lose your authenticator device.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


