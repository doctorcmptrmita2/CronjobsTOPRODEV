<x-public-layout title="Terms of Service">
    <!-- Hero Section -->
    <section class="relative pt-32 pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-accent-500/5 via-transparent to-transparent"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-accent-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-accent-500/10 border border-accent-500/30 rounded-full text-sm mb-6">
                <svg class="w-4 h-4 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="text-accent-300">Legal Agreement</span>
            </div>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight mb-6">
                <span class="text-midnight-50">Terms of</span>
                <span class="text-gradient"> Service</span>
            </h1>
            
            <p class="text-xl text-midnight-400 max-w-2xl mx-auto">
                The rules of the road. Simple, fair, and transparent.
            </p>
            
            <p class="text-sm text-midnight-500 mt-6">
                Last updated: {{ now()->format('F d, Y') }}
            </p>
        </div>
    </section>

    <!-- TL;DR Section -->
    <section class="py-12 border-y border-midnight-800">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <span class="text-xs font-semibold text-accent-400 uppercase tracking-wider">TL;DR</span>
                <h2 class="text-2xl font-bold text-midnight-50 mt-2">The Human-Readable Version</h2>
            </div>
            <div class="grid md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="text-sm text-midnight-300">Use our service for legitimate purposes</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <p class="text-sm text-midnight-300">Only schedule jobs to URLs you own</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <p class="text-sm text-midnight-300">Pay on time if you're on a paid plan</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <p class="text-sm text-midnight-300">Don't abuse, attack, or spam anyone</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Navigation -->
            <div class="card p-6 mb-12 sticky top-20 z-10 bg-midnight-900/95 backdrop-blur-sm">
                <div class="flex flex-wrap gap-2 justify-center">
                    @foreach(['Service', 'Account', 'Use', 'Payment', 'Liability', 'General'] as $i => $section)
                    <a href="#terms-{{ $i + 1 }}" class="px-4 py-2 text-sm text-midnight-400 hover:text-accent-400 hover:bg-midnight-800 rounded-lg transition-colors">
                        {{ $section }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Sections -->
            <div class="space-y-16">
                
                <!-- Section 1: The Service -->
                <div id="terms-1" class="scroll-mt-32">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-accent-500 to-accent-600 rounded-xl flex items-center justify-center text-xl font-bold text-midnight-950">1</div>
                        <h2 class="text-2xl font-bold text-midnight-50">The Service</h2>
                    </div>
                    
                    <div class="card p-6 mb-6">
                        <h3 class="text-lg font-semibold text-midnight-100 mb-4">What Cronjobs.to Does</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-emerald-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <p class="text-sm text-midnight-300">Schedule HTTP requests to any URL at specified intervals</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                </div>
                                <p class="text-sm text-midnight-300">Monitor execution and provide detailed logs</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                </div>
                                <p class="text-sm text-midnight-300">Send alerts when jobs fail</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-accent-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                                </div>
                                <p class="text-sm text-midnight-300">Provide API access for automation</p>
                            </div>
                        </div>
                    </div>

                    <div class="card p-6 bg-gradient-to-br from-midnight-800/50 to-midnight-900">
                        <h4 class="font-semibold text-midnight-100 mb-2">Service Availability</h4>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex-1 bg-midnight-800 rounded-lg p-3 text-center">
                                <p class="text-sm text-midnight-500">Free Plan</p>
                                <p class="text-midnight-200">Best effort</p>
                            </div>
                            <div class="flex-1 bg-accent-500/10 border border-accent-500/30 rounded-lg p-3 text-center">
                                <p class="text-sm text-accent-400">Pro Plan</p>
                                <p class="text-accent-300 font-semibold">99.9% SLA</p>
                            </div>
                        </div>
                        <p class="text-xs text-midnight-500">We may modify or discontinue features with reasonable notice.</p>
                    </div>
                </div>

                <!-- Section 2: Your Account -->
                <div id="terms-2" class="scroll-mt-32">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-xl font-bold text-white">2</div>
                        <h2 class="text-2xl font-bold text-midnight-50">Your Account</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="card p-5">
                            <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <h4 class="font-semibold text-midnight-100 mb-2">Requirements</h4>
                            <ul class="text-sm text-midnight-400 space-y-1">
                                <li>• Be at least 16 years old</li>
                                <li>• Provide accurate info</li>
                                <li>• One account per person</li>
                            </ul>
                        </div>
                        <div class="card p-5">
                            <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <h4 class="font-semibold text-midnight-100 mb-2">Security</h4>
                            <ul class="text-sm text-midnight-400 space-y-1">
                                <li>• Keep password secret</li>
                                <li>• Report unauthorized access</li>
                                <li>• Enable 2FA (recommended)</li>
                            </ul>
                        </div>
                        <div class="card p-5">
                            <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <h4 class="font-semibold text-midnight-100 mb-2">Responsibility</h4>
                            <ul class="text-sm text-midnight-400 space-y-1">
                                <li>• You own your actions</li>
                                <li>• You control your data</li>
                                <li>• You manage your jobs</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Acceptable Use -->
                <div id="terms-3" class="scroll-mt-32">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center text-xl font-bold text-white">3</div>
                        <h2 class="text-2xl font-bold text-midnight-50">Acceptable Use</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Allowed -->
                        <div class="card p-6 border-l-4 border-l-emerald-500">
                            <h3 class="text-lg font-semibold text-emerald-400 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                You CAN
                            </h3>
                            <ul class="space-y-3">
                                @foreach([
                                    'Schedule jobs to your own endpoints',
                                    'Use for personal or business projects',
                                    'Integrate with your applications',
                                    'Access via API within rate limits',
                                    'Share job results with your team',
                                ] as $item)
                                <li class="flex items-start gap-2 text-sm text-midnight-300">
                                    <svg class="w-4 h-4 text-emerald-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    {{ $item }}
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Prohibited -->
                        <div class="card p-6 border-l-4 border-l-red-500">
                            <h3 class="text-lg font-semibold text-red-400 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                You CANNOT
                            </h3>
                            <ul class="space-y-3">
                                @foreach([
                                    'DDoS or flood any server',
                                    'Send spam or phishing',
                                    'Scrape without permission',
                                    'Distribute malware',
                                    'Violate any laws',
                                ] as $item)
                                <li class="flex items-start gap-2 text-sm text-midnight-300">
                                    <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    {{ $item }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card p-4 mt-6 bg-red-500/5 border-red-500/20">
                        <p class="text-sm text-red-300 flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            Violations may result in immediate account termination without refund.
                        </p>
                    </div>
                </div>

                <!-- Section 4: Payment -->
                <div id="terms-4" class="scroll-mt-32">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center text-xl font-bold text-white">4</div>
                        <h2 class="text-2xl font-bold text-midnight-50">Payment & Billing</h2>
                    </div>
                    
                    <div class="card p-6 mb-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-semibold text-midnight-100 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                    Billing
                                </h4>
                                <ul class="text-sm text-midnight-400 space-y-2">
                                    <li>• Billed monthly or annually in advance</li>
                                    <li>• Prices in USD</li>
                                    <li>• Auto-renewal unless cancelled</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-semibold text-midnight-100 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" /></svg>
                                    Refunds
                                </h4>
                                <ul class="text-sm text-midnight-400 space-y-2">
                                    <li>• Generally non-refundable</li>
                                    <li>• No prorated refunds for cancellation</li>
                                    <li>• Contact us for exceptional cases</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 card bg-accent-500/5 border-accent-500/30">
                        <div class="w-12 h-12 bg-accent-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-xl font-bold text-midnight-950">$5</span>
                        </div>
                        <div>
                            <p class="font-semibold text-midnight-100">Pro Plan: $5/month</p>
                            <p class="text-sm text-midnight-400">100 jobs, 1-min intervals, 90-day logs, priority support</p>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Liability -->
                <div id="terms-5" class="scroll-mt-32">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center text-xl font-bold text-white">5</div>
                        <h2 class="text-2xl font-bold text-midnight-50">Liability & Disclaimers</h2>
                    </div>
                    
                    <div class="card p-6 bg-gradient-to-br from-amber-500/5 to-transparent border-amber-500/20">
                        <h3 class="text-lg font-semibold text-amber-400 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            Important Legal Notice
                        </h3>
                        
                        <div class="space-y-4 text-sm text-midnight-300">
                            <p>
                                <strong class="text-midnight-100">AS-IS Service:</strong> The service is provided "as is" without warranties of any kind, express or implied.
                            </p>
                            <p>
                                <strong class="text-midnight-100">Limitation:</strong> We're not liable for indirect, incidental, or consequential damages arising from your use of the service.
                            </p>
                            <p>
                                <strong class="text-midnight-100">Maximum Liability:</strong> Our total liability is limited to the greater of $100 or the fees you paid in the past 12 months.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Section 6: General -->
                <div id="terms-6" class="scroll-mt-32">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center text-xl font-bold text-white">6</div>
                        <h2 class="text-2xl font-bold text-midnight-50">General Terms</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="card p-5">
                            <h4 class="font-semibold text-midnight-100 mb-2">Termination</h4>
                            <p class="text-sm text-midnight-400">Either party can terminate at any time. Your data will be deleted per our retention policy.</p>
                        </div>
                        <div class="card p-5">
                            <h4 class="font-semibold text-midnight-100 mb-2">Changes</h4>
                            <p class="text-sm text-midnight-400">We may update these terms with 30 days notice. Continued use means acceptance.</p>
                        </div>
                        <div class="card p-5">
                            <h4 class="font-semibold text-midnight-100 mb-2">Governing Law</h4>
                            <p class="text-sm text-midnight-400">These terms are governed by Delaware law, USA.</p>
                        </div>
                        <div class="card p-5">
                            <h4 class="font-semibold text-midnight-100 mb-2">Disputes</h4>
                            <p class="text-sm text-midnight-400">Resolved through binding arbitration. No class actions.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Agreement CTA -->
    <section class="py-16 border-t border-midnight-800">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="card p-8 bg-gradient-to-br from-midnight-900 via-midnight-900 to-accent-900/20">
                <div class="w-16 h-16 bg-accent-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-midnight-50 mb-3">Ready to Get Started?</h2>
                <p class="text-midnight-400 mb-6">
                    By creating an account, you agree to these terms and our <a href="{{ route('privacy') }}" class="text-accent-400 hover:underline">Privacy Policy</a>.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Create Free Account
                    </a>
                    <a href="{{ route('contact') }}" class="btn-secondary">
                        Questions? Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
