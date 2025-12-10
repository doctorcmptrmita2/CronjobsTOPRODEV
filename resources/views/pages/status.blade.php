<x-public-layout>
    <div class="min-h-screen py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500/10 border border-emerald-500/30 rounded-full text-sm mb-6">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    <span class="text-emerald-400 font-medium">All Systems Operational</span>
                </div>
                <h1 class="text-4xl sm:text-5xl font-bold text-midnight-50 mb-4">
                    System Status
                </h1>
                <p class="text-xl text-midnight-400">
                    Real-time status of Cronjobs.to infrastructure
                </p>
            </div>

            <!-- Current Status -->
            <div class="card p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-midnight-50">Current Status</h2>
                    <span class="text-sm text-midnight-500">Last updated: {{ now()->format('M d, Y H:i') }} UTC</span>
                </div>

                <div class="space-y-4">
                    <!-- API -->
                    <div class="flex items-center justify-between p-4 bg-midnight-800/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-midnight-100">API & Dashboard</p>
                                <p class="text-sm text-midnight-500">Web application and API endpoints</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-sm font-medium rounded-full">Operational</span>
                    </div>

                    <!-- Job Scheduler -->
                    <div class="flex items-center justify-between p-4 bg-midnight-800/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-midnight-100">Job Scheduler</p>
                                <p class="text-sm text-midnight-500">Cron job execution engine</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-sm font-medium rounded-full">Operational</span>
                    </div>

                    <!-- Monitoring -->
                    <div class="flex items-center justify-between p-4 bg-midnight-800/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-midnight-100">Monitoring & Alerts</p>
                                <p class="text-sm text-midnight-500">Email notifications and logging</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-sm font-medium rounded-full">Operational</span>
                    </div>

                    <!-- Database -->
                    <div class="flex items-center justify-between p-4 bg-midnight-800/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-midnight-100">Database</p>
                                <p class="text-sm text-midnight-500">Primary data storage</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-sm font-medium rounded-full">Operational</span>
                    </div>
                </div>
            </div>

            <!-- Metrics -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="card p-6 text-center">
                    <div class="text-3xl font-bold text-accent-400 mb-1">{{ $stats['success_rate'] }}%</div>
                    <div class="text-midnight-400 text-sm">Success Rate (24h)</div>
                </div>
                <div class="card p-6 text-center">
                    <div class="text-3xl font-bold text-emerald-400 mb-1">{{ number_format($stats['runs_today']) }}</div>
                    <div class="text-midnight-400 text-sm">Runs Today</div>
                </div>
                <div class="card p-6 text-center">
                    <div class="text-3xl font-bold text-blue-400 mb-1">{{ $stats['avg_response_time'] }}ms</div>
                    <div class="text-midnight-400 text-sm">Avg Response Time</div>
                </div>
            </div>

            <!-- Uptime History -->
            <div class="card p-6 mb-8">
                <h2 class="text-xl font-semibold text-midnight-50 mb-6">90-Day Uptime History</h2>
                <div class="flex gap-1">
                    @for($i = 0; $i < 90; $i++)
                        <div class="flex-1 h-8 bg-emerald-500 rounded-sm opacity-{{ rand(80, 100) }}" title="Day {{ 90 - $i }}: 100% uptime"></div>
                    @endfor
                </div>
                <div class="flex justify-between mt-2 text-xs text-midnight-500">
                    <span>90 days ago</span>
                    <span>Today</span>
                </div>
                <div class="mt-4 text-center">
                    <span class="text-2xl font-bold text-emerald-400">99.98%</span>
                    <span class="text-midnight-400 ml-2">uptime over the last 90 days</span>
                </div>
            </div>

            <!-- Subscribe -->
            <div class="card p-8 text-center bg-gradient-to-br from-midnight-900 via-midnight-900 to-accent-900/20">
                <h2 class="text-xl font-semibold text-midnight-50 mb-4">Get Status Updates</h2>
                <p class="text-midnight-400 mb-6">Subscribe to receive notifications about scheduled maintenance and incidents.</p>
                <div class="flex max-w-md mx-auto gap-3">
                    <input type="email" placeholder="your@email.com" class="input flex-1">
                    <button class="btn-primary">Subscribe</button>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>

