<x-public-layout>
    <div class="min-h-screen py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero -->
            <div class="text-center mb-16">
                <h1 class="text-4xl sm:text-5xl font-bold text-midnight-50 mb-6">
                    About <span class="text-gradient">Cronjobs.to</span>
                </h1>
                <p class="text-xl text-midnight-400 max-w-2xl mx-auto">
                    We believe scheduling should be simple. That's why we built the most reliable cron job service for modern developers.
                </p>
            </div>

            <!-- Story Section -->
            <div class="card p-8 mb-12">
                <h2 class="text-2xl font-bold text-midnight-50 mb-6 flex items-center gap-3">
                    <span class="w-10 h-10 bg-accent-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </span>
                    Our Story
                </h2>
                <div class="prose prose-invert max-w-none text-midnight-300">
                    <p>
                        Cronjobs.to was born out of frustration. As developers, we spent countless hours setting up cron jobs, managing servers, and debugging scheduled tasks that mysteriously stopped working at 3 AM.
                    </p>
                    <p class="mt-4">
                        We asked ourselves: "Why is something so fundamental still so complicated?" The answer was clear — it shouldn't be.
                    </p>
                    <p class="mt-4">
                        So we built Cronjobs.to: a simple, reliable, and developer-friendly service that handles all the complexity of scheduled HTTP tasks. No servers to manage, no crontabs to configure, no 3 AM wake-up calls.
                    </p>
                </div>
            </div>

            <!-- Values -->
            <div class="grid md:grid-cols-3 gap-6 mb-12">
                <div class="card p-6 text-center">
                    <div class="w-14 h-14 bg-emerald-500/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-midnight-50 mb-2">Reliability First</h3>
                    <p class="text-midnight-400 text-sm">99.9% uptime guarantee. Your jobs run on time, every time.</p>
                </div>

                <div class="card p-6 text-center">
                    <div class="w-14 h-14 bg-blue-500/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-midnight-50 mb-2">Developer Experience</h3>
                    <p class="text-midnight-400 text-sm">Built by developers, for developers. Simple API, clear documentation.</p>
                </div>

                <div class="card p-6 text-center">
                    <div class="w-14 h-14 bg-purple-500/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-midnight-50 mb-2">Security & Privacy</h3>
                    <p class="text-midnight-400 text-sm">Your data is encrypted and never shared. GDPR compliant.</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="card p-8 bg-gradient-to-br from-midnight-900 via-midnight-900 to-accent-900/20">
                <h2 class="text-2xl font-bold text-midnight-50 mb-8 text-center">Trusted by Developers Worldwide</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-accent-400 mb-1">10K+</div>
                        <div class="text-midnight-400 text-sm">Active Jobs</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-accent-400 mb-1">99.9%</div>
                        <div class="text-midnight-400 text-sm">Uptime</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-accent-400 mb-1">1M+</div>
                        <div class="text-midnight-400 text-sm">Runs/Month</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-accent-400 mb-1">50+</div>
                        <div class="text-midnight-400 text-sm">Countries</div>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center mt-12">
                <a href="{{ route('landing') }}" class="btn-primary text-lg px-8 py-4">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Start Scheduling Now
                </a>
            </div>
        </div>
    </div>
</x-public-layout>

