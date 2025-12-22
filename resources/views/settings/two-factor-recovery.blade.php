<x-app-layout>
    <x-slot name="title">Recovery Codes</x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('settings.two-factor') }}" class="p-2 text-midnight-400 hover:text-midnight-100 hover:bg-midnight-800 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-midnight-50">Recovery Codes</h1>
                <p class="text-sm text-midnight-400 mt-1">Use these codes to access your account if you lose your authenticator device</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        @if($justEnabled)
        <div class="card p-6 mb-6 border-emerald-500/50 bg-emerald-500/5">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-emerald-500/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-emerald-300">Two-Factor Authentication Enabled!</h3>
                    <p class="text-sm text-midnight-400 mt-1">
                        Your account is now protected. Please save these recovery codes in a safe place.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="card p-6">
            <!-- Warning -->
            <div class="bg-amber-500/10 border border-amber-500/30 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 text-amber-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-amber-300">Save these codes securely</h4>
                        <p class="text-sm text-midnight-400 mt-1">
                            Each code can only be used once. Store them in a password manager or print them out and keep them in a safe place.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Recovery Codes -->
            <div class="bg-midnight-800 rounded-lg p-6 mb-6">
                <div class="grid grid-cols-2 gap-3">
                    @foreach($recoveryCodes as $code)
                    <code class="text-sm font-mono text-midnight-200 bg-midnight-900 px-3 py-2 rounded select-all text-center">
                        {{ $code }}
                    </code>
                    @endforeach
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap gap-3">
                <button onclick="copyAllCodes()" class="btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    Copy All Codes
                </button>
                <button onclick="downloadCodes()" class="btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                </button>
                <button onclick="printCodes()" class="btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print
                </button>
            </div>

            <!-- Regenerate -->
            <div class="mt-8 pt-6 border-t border-midnight-800">
                <h4 class="text-sm font-medium text-midnight-100 mb-2">Regenerate Recovery Codes</h4>
                <p class="text-sm text-midnight-400 mb-4">
                    If you've used some recovery codes or think they may have been compromised, you can generate new ones.
                </p>
                
                <form action="{{ route('settings.two-factor.regenerate-codes') }}" method="POST" onsubmit="return confirm('This will invalidate your existing recovery codes. Continue?')">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="password" class="label">Confirm Password</label>
                        <input type="password" name="password" id="password" 
                               class="input @error('password') input-error @enderror"
                               placeholder="Enter your password">
                        @error('password')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Generate New Codes
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const recoveryCodes = @json($recoveryCodes);

        function copyAllCodes() {
            navigator.clipboard.writeText(recoveryCodes.join('\n'));
            alert('Recovery codes copied to clipboard!');
        }

        function downloadCodes() {
            const content = 'Cronjobs.to Recovery Codes\n' +
                'Generated: {{ now()->format('Y-m-d H:i:s') }}\n\n' +
                recoveryCodes.join('\n') +
                '\n\nKeep these codes in a safe place. Each code can only be used once.';
            
            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'cronjobs-recovery-codes.txt';
            a.click();
            URL.revokeObjectURL(url);
        }

        function printCodes() {
            const printWindow = window.open('', '', 'width=600,height=400');
            printWindow.document.write('<html><head><title>Recovery Codes</title></head><body>');
            printWindow.document.write('<h1>Cronjobs.to Recovery Codes</h1>');
            printWindow.document.write('<p>Generated: {{ now()->format('Y-m-d H:i:s') }}</p>');
            printWindow.document.write('<ul style="font-family: monospace; font-size: 14px;">');
            recoveryCodes.forEach(code => {
                printWindow.document.write('<li style="margin: 5px 0;">' + code + '</li>');
            });
            printWindow.document.write('</ul>');
            printWindow.document.write('<p><small>Each code can only be used once. Keep these codes secure.</small></p>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</x-app-layout>


