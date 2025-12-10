<x-public-layout title="Privacy Policy">
    <!-- Hero Section -->
    <section class="relative pt-32 pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 via-transparent to-transparent"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-emerald-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500/10 border border-emerald-500/30 rounded-full text-sm mb-6">
                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span class="text-emerald-300">Your privacy is our priority</span>
            </div>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight mb-6">
                <span class="text-midnight-50">Privacy</span>
                <span class="text-gradient"> Policy</span>
            </h1>
            
            <p class="text-xl text-midnight-400 max-w-2xl mx-auto">
                We believe in transparency. Here's exactly how we handle your data.
            </p>
            
            <p class="text-sm text-midnight-500 mt-6">
                Last updated: {{ now()->format('F d, Y') }}
            </p>
        </div>
    </section>

    <!-- Trust Badges -->
    <section class="py-12 border-y border-midnight-800">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="flex items-center gap-3 justify-center">
                    <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-midnight-100 text-sm">SSL Encrypted</p>
                        <p class="text-xs text-midnight-500">256-bit TLS</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 justify-center">
                    <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-midnight-100 text-sm">GDPR Ready</p>
                        <p class="text-xs text-midnight-500">EU Compliant</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 justify-center">
                    <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-midnight-100 text-sm">No Data Selling</p>
                        <p class="text-xs text-midnight-500">Ever. Period.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 justify-center">
                    <div class="w-10 h-10 bg-accent-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-midnight-100 text-sm">Delete Anytime</p>
                        <p class="text-xs text-midnight-500">Full control</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Summary Cards -->
    <section class="py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-midnight-50 text-center mb-8">The Short Version</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="card p-6 text-center hover:border-emerald-500/50 transition-colors">
                    <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-midnight-100 mb-2">We Collect Less</h3>
                    <p class="text-midnight-400 text-sm">Only the data we absolutely need to run your cron jobs. Nothing more.</p>
                </div>
                <div class="card p-6 text-center hover:border-blue-500/50 transition-colors">
                    <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-midnight-100 mb-2">We Protect More</h3>
                    <p class="text-midnight-400 text-sm">Bank-level encryption for all your data, both in transit and at rest.</p>
                </div>
                <div class="card p-6 text-center hover:border-purple-500/50 transition-colors">
                    <div class="w-14 h-14 bg-purple-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-midnight-100 mb-2">You're In Control</h3>
                    <p class="text-midnight-400 text-sm">Export or delete your data anytime. No questions asked.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="pb-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Navigation -->
            <div class="card p-6 mb-12 sticky top-20 z-10 bg-midnight-900/95 backdrop-blur-sm">
                <div class="flex flex-wrap gap-2 justify-center">
                    @foreach(['Collect', 'Use', 'Share', 'Protect', 'Retain', 'Rights'] as $i => $section)
                    <a href="#section-{{ $i + 1 }}" class="px-4 py-2 text-sm text-midnight-400 hover:text-accent-400 hover:bg-midnight-800 rounded-lg transition-colors">
                        {{ $section }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Sections -->
            <div class="space-y-16">
                
                <!-- Section 1: What We Collect -->
                <div id="section-1" class="scroll-mt-32">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center text-xl font-bold text-white">1</div>
                        <h2 class="text-2xl font-bold text-midnight-50">What We Collect</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="card p-5 border-l-4 border-l-emerald-500">
                            <h4 class="font-semibold text-midnight-100 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                Account Info
                            </h4>
                            <ul class="text-sm text-midnight-400 space-y-1">
                                <li>• Email address</li>
                                <li>• Name (optional)</li>
                                <li>• Password (hashed)</li>
                                <li>• Timezone preference</li>
                            </ul>
                        </div>
                        <div class="card p-5 border-l-4 border-l-blue-500">
                            <h4 class="font-semibold text-midnight-100 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Job Data
                            </h4>
                            <ul class="text-sm text-midnight-400 space-y-1">
                                <li>• URLs you schedule</li>
                                <li>• HTTP methods & headers</li>
                                <li>• Cron expressions</li>
                                <li>• Execution logs</li>
                            </ul>
                        </div>
                        <div class="card p-5 border-l-4 border-l-purple-500">
                            <h4 class="font-semibold text-midnight-100 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                Usage Analytics
                            </h4>
                            <ul class="text-sm text-midnight-400 space-y-1">
                                <li>• Pages visited</li>
                                <li>• Features used</li>
                                <li>• Browser type</li>
                                <li>• Anonymized IP</li>
                            </ul>
                        </div>
                        <div class="card p-5 border-l-4 border-l-accent-500">
                            <h4 class="font-semibold text-midnight-100 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                Payment (Pro)
                            </h4>
                            <ul class="text-sm text-midnight-400 space-y-1">
                                <li>• Billing email</li>
                                <li>• Payment method (via Stripe)</li>
                                <li>• We never see card numbers</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Section 2: How We Use It -->
                <div id="section-2" class="scroll-mt-32">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-xl font-bold text-white">2</div>
                        <h2 class="text-2xl font-bold text-midnight-50">How We Use Your Data</h2>
                    </div>
                    
                    <div class="card p-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-semibold text-emerald-400 mb-3">✓ We DO Use It For</h4>
                                <ul class="text-midnight-300 space-y-2 text-sm">
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-emerald-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        Running your scheduled jobs
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-emerald-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        Sending failure alerts
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-emerald-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        Improving the service
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-emerald-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        Customer support
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-semibold text-red-400 mb-3">✗ We NEVER Use It For</h4>
                                <ul class="text-midnight-300 space-y-2 text-sm">
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        Selling to third parties
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        Targeted advertising
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        Profiling your behavior
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        Sharing without consent
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Data Sharing -->
                <div id="section-3" class="scroll-mt-32">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center text-xl font-bold text-white">3</div>
                        <h2 class="text-2xl font-bold text-midnight-50">Who We Share With</h2>
                    </div>
                    
                    <div class="card p-6 bg-gradient-to-br from-red-500/5 to-transparent border-red-500/20 mb-6">
                        <p class="text-lg text-red-400 font-semibold flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                            We do NOT sell your data. Ever. To anyone.
                        </p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="card p-5">
                            <div class="w-10 h-10 bg-midnight-800 rounded-lg flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-midnight-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2" /></svg>
                            </div>
                            <h4 class="font-semibold text-midnight-100 mb-1">Infrastructure</h4>
                            <p class="text-xs text-midnight-500">Hosting & CDN providers</p>
                        </div>
                        <div class="card p-5">
                            <div class="w-10 h-10 bg-midnight-800 rounded-lg flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-midnight-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                            </div>
                            <h4 class="font-semibold text-midnight-100 mb-1">Payments</h4>
                            <p class="text-xs text-midnight-500">Stripe (PCI compliant)</p>
                        </div>
                        <div class="card p-5">
                            <div class="w-10 h-10 bg-midnight-800 rounded-lg flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-midnight-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <h4 class="font-semibold text-midnight-100 mb-1">Email</h4>
                            <p class="text-xs text-midnight-500">Transactional emails only</p>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Security -->
                <div id="section-4" class="scroll-mt-32">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-accent-500 to-accent-600 rounded-xl flex items-center justify-center text-xl font-bold text-midnight-950">4</div>
                        <h2 class="text-2xl font-bold text-midnight-50">How We Protect Your Data</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach([
                            ['TLS 1.3', 'All data encrypted in transit', 'emerald'],
                            ['AES-256', 'All data encrypted at rest', 'blue'],
                            ['Bcrypt', 'Passwords securely hashed', 'purple'],
                            ['SOC 2', 'Infrastructure compliance', 'accent'],
                        ] as $item)
                        <div class="card p-5 flex items-center gap-4">
                            <div class="w-16 h-16 bg-{{ $item[2] }}-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="text-{{ $item[2] }}-400 font-mono font-bold text-sm">{{ $item[0] }}</span>
                            </div>
                            <p class="text-midnight-300">{{ $item[1] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Section 5: Retention -->
                <div id="section-5" class="scroll-mt-32">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center text-xl font-bold text-white">5</div>
                        <h2 class="text-2xl font-bold text-midnight-50">Data Retention</h2>
                    </div>
                    
                    <div class="card overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-midnight-800">
                                <tr>
                                    <th class="text-left py-4 px-6 text-midnight-300 font-medium">Data Type</th>
                                    <th class="text-left py-4 px-6 text-midnight-300 font-medium">Retention</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-midnight-800">
                                <tr><td class="py-4 px-6 text-midnight-100">Account data</td><td class="py-4 px-6 text-midnight-400">Until you delete</td></tr>
                                <tr><td class="py-4 px-6 text-midnight-100">Job logs (Free)</td><td class="py-4 px-6 text-midnight-400">30 days</td></tr>
                                <tr><td class="py-4 px-6 text-midnight-100">Job logs (Pro)</td><td class="py-4 px-6 text-midnight-400">90 days</td></tr>
                                <tr><td class="py-4 px-6 text-midnight-100">Payment records</td><td class="py-4 px-6 text-midnight-400">7 years (legal)</td></tr>
                                <tr><td class="py-4 px-6 text-midnight-100">Analytics</td><td class="py-4 px-6 text-midnight-400">26 months (anon)</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 6: Your Rights -->
                <div id="section-6" class="scroll-mt-32">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center text-xl font-bold text-white">6</div>
                        <h2 class="text-2xl font-bold text-midnight-50">Your Rights</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach([
                            ['Access', 'Download your data', 'eye'],
                            ['Correct', 'Fix inaccurate info', 'pencil'],
                            ['Delete', 'Erase everything', 'trash'],
                            ['Export', 'Take it with you', 'download'],
                        ] as $right)
                        <div class="card p-5 text-center hover:border-accent-500/50 transition-colors group">
                            <div class="w-12 h-12 bg-midnight-800 group-hover:bg-accent-500/10 rounded-xl flex items-center justify-center mx-auto mb-3 transition-colors">
                                @if($right[2] === 'eye')
                                <svg class="w-5 h-5 text-midnight-400 group-hover:text-accent-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                @elseif($right[2] === 'pencil')
                                <svg class="w-5 h-5 text-midnight-400 group-hover:text-accent-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                @elseif($right[2] === 'trash')
                                <svg class="w-5 h-5 text-midnight-400 group-hover:text-accent-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                @else
                                <svg class="w-5 h-5 text-midnight-400 group-hover:text-accent-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                @endif
                            </div>
                            <h4 class="font-semibold text-midnight-100">{{ $right[0] }}</h4>
                            <p class="text-xs text-midnight-500">{{ $right[1] }}</p>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="card p-6 mt-6 text-center bg-gradient-to-br from-midnight-900 to-midnight-950">
                        <p class="text-midnight-300 mb-4">Want to exercise your rights?</p>
                        <a href="{{ route('contact') }}" class="btn-primary">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Contact Us
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-public-layout>
