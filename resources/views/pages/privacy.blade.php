<x-public-layout title="Privacy Policy">
    <div class="min-h-screen py-24">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="text-center mb-16">
                <h1 class="text-4xl sm:text-5xl font-bold text-midnight-50 mb-4">Privacy Policy</h1>
                <p class="text-midnight-400">Last updated: {{ now()->format('F d, Y') }}</p>
            </div>

            <!-- Summary Box -->
            <div class="card p-6 mb-12 border-l-4 border-l-emerald-500">
                <p class="text-midnight-300">
                    <strong class="text-emerald-400">TL;DR:</strong> We collect only what's necessary, never sell your data, and you can delete everything anytime.
                </p>
            </div>

            <!-- Content -->
            <div class="space-y-12">
                
                <section>
                    <h2 class="text-xl font-bold text-midnight-50 mb-4">1. What We Collect</h2>
                    <ul class="space-y-2 text-midnight-300">
                        <li>• <strong class="text-midnight-100">Account:</strong> Email, password (hashed), timezone</li>
                        <li>• <strong class="text-midnight-100">Jobs:</strong> URLs, schedules, headers, execution logs</li>
                        <li>• <strong class="text-midnight-100">Usage:</strong> Pages visited, features used</li>
                        <li>• <strong class="text-midnight-100">Payment:</strong> Via Stripe (we never see your card)</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-midnight-50 mb-4">2. How We Use It</h2>
                    <ul class="space-y-2 text-midnight-300">
                        <li>• Run your scheduled cron jobs</li>
                        <li>• Send failure alerts</li>
                        <li>• Improve our service</li>
                        <li>• Provide customer support</li>
                    </ul>
                    <p class="mt-4 text-red-400 font-medium">We never sell your data to third parties.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-midnight-50 mb-4">3. Data Sharing</h2>
                    <p class="text-midnight-300 mb-3">We only share data with trusted service providers:</p>
                    <ul class="space-y-2 text-midnight-300">
                        <li>• Infrastructure (hosting, CDN)</li>
                        <li>• Payment processing (Stripe)</li>
                        <li>• Email delivery (transactional only)</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-midnight-50 mb-4">4. Security</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="card p-4 text-center">
                            <p class="text-accent-400 font-mono font-bold">TLS 1.3</p>
                            <p class="text-xs text-midnight-500">In transit</p>
                        </div>
                        <div class="card p-4 text-center">
                            <p class="text-accent-400 font-mono font-bold">AES-256</p>
                            <p class="text-xs text-midnight-500">At rest</p>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-midnight-50 mb-4">5. Data Retention</h2>
                    <ul class="space-y-2 text-midnight-300">
                        <li>• <strong class="text-midnight-100">Account:</strong> Until you delete</li>
                        <li>• <strong class="text-midnight-100">Logs (Free):</strong> 30 days</li>
                        <li>• <strong class="text-midnight-100">Logs (Pro):</strong> 90 days</li>
                        <li>• <strong class="text-midnight-100">Payments:</strong> 7 years (legal)</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-midnight-50 mb-4">6. Your Rights</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="card p-3 text-center">
                            <p class="text-sm font-medium text-midnight-100">Access</p>
                        </div>
                        <div class="card p-3 text-center">
                            <p class="text-sm font-medium text-midnight-100">Correct</p>
                        </div>
                        <div class="card p-3 text-center">
                            <p class="text-sm font-medium text-midnight-100">Delete</p>
                        </div>
                        <div class="card p-3 text-center">
                            <p class="text-sm font-medium text-midnight-100">Export</p>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-midnight-50 mb-4">7. Cookies</h2>
                    <p class="text-midnight-300">We use essential cookies only: session management, security (CSRF), and preferences.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-midnight-50 mb-4">8. Changes</h2>
                    <p class="text-midnight-300">We'll notify you of material changes at least 30 days before they take effect.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-midnight-50 mb-4">9. Contact</h2>
                    <p class="text-midnight-300">
                        Questions? Email <a href="mailto:privacy@cronjobs.to" class="text-accent-400 hover:underline">privacy@cronjobs.to</a> or use our <a href="{{ route('contact') }}" class="text-accent-400 hover:underline">contact form</a>.
                    </p>
                </section>

            </div>
        </div>
    </div>
</x-public-layout>
