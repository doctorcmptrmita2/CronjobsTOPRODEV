<x-public-layout>
    <!-- Hero Section with Cron Editor -->
    <section class="relative pt-24 pb-16 overflow-hidden">
        <!-- Background effects -->
        <div class="absolute inset-0 bg-gradient-to-b from-accent-500/5 via-transparent to-transparent"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-accent-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-midnight-900 border border-midnight-800 rounded-full text-sm mb-6">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    <span class="text-midnight-300">No signup required to try</span>
                </div>

                <!-- Heading -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight mb-6">
                    <span class="text-midnight-50">The Last Cron Tool</span>
                    <br>
                    <span class="text-gradient">You'll Need</span>
                </h1>

                <!-- Subheading -->
                <p class="text-xl text-midnight-300 max-w-2xl mx-auto">
                    Simple to set up. Reliable every time. Powerful when it matters.
                </p>
            </div>

            <!-- Interactive Job Creator -->
            <div class="max-w-4xl mx-auto">
                <form id="job-creator-form" action="{{ route('guest.preview') }}" method="POST">
                    @csrf
                    <div class="card p-6 lg:p-8">
                        <!-- URL Input -->
                        <div class="mb-6">
                            <label for="url" class="label">URL to Call <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-midnight-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                </div>
                                <input type="url" name="url" id="url" required
                                       class="input pl-12 text-lg font-mono" 
                                       placeholder="https://api.yoursite.com/cron/backup"
                                       value="{{ old('url', session('pending_job.url', '')) }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- HTTP Method -->
                            <div>
                                <label for="http_method" class="label">HTTP Method</label>
                                <select name="http_method" id="http_method" class="select">
                                    @foreach(['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $method)
                                    <option value="{{ $method }}" {{ old('http_method', session('pending_job.http_method', 'GET')) === $method ? 'selected' : '' }}>
                                        {{ $method }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Timezone -->
                            <div>
                                <label for="timezone" class="label">Timezone</label>
                                <select name="timezone" id="timezone" class="select">
                                    @foreach(['UTC', 'America/New_York', 'America/Los_Angeles', 'Europe/London', 'Europe/Paris', 'Europe/Istanbul', 'Asia/Tokyo', 'Asia/Shanghai', 'Australia/Sydney'] as $tz)
                                    <option value="{{ $tz }}" {{ old('timezone', session('pending_job.timezone', 'UTC')) === $tz ? 'selected' : '' }}>
                                        {{ $tz }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Cron Expression Builder -->
                        <div class="mb-6">
                            <label class="label mb-4">Schedule (Cron Expression)</label>
                            
                            <!-- Quick Presets -->
                            <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 mb-4">
                                <button type="button" onclick="setCronPreset('*/5 * * * *', 'Every 5 minutes')" class="px-3 py-2 text-sm bg-midnight-800 text-midnight-300 rounded-lg border border-midnight-700 hover:border-accent-500 hover:text-accent-400 transition-all">Every 5 min</button>
                                <button type="button" onclick="setCronPreset('*/15 * * * *', 'Every 15 minutes')" class="px-3 py-2 text-sm bg-midnight-800 text-midnight-300 rounded-lg border border-midnight-700 hover:border-accent-500 hover:text-accent-400 transition-all">Every 15 min</button>
                                <button type="button" onclick="setCronPreset('0 * * * *', 'Every hour')" class="px-3 py-2 text-sm bg-midnight-800 text-midnight-300 rounded-lg border border-midnight-700 hover:border-accent-500 hover:text-accent-400 transition-all">Every hour</button>
                                <button type="button" onclick="setCronPreset('0 */6 * * *', 'Every 6 hours')" class="px-3 py-2 text-sm bg-midnight-800 text-midnight-300 rounded-lg border border-midnight-700 hover:border-accent-500 hover:text-accent-400 transition-all">Every 6 hours</button>
                                <button type="button" onclick="setCronPreset('0 0 * * *', 'Every day at midnight')" class="px-3 py-2 text-sm bg-midnight-800 text-midnight-300 rounded-lg border border-midnight-700 hover:border-accent-500 hover:text-accent-400 transition-all">Daily</button>
                                <button type="button" onclick="setCronPreset('0 0 * * 0', 'Every Sunday at midnight')" class="px-3 py-2 text-sm bg-midnight-800 text-midnight-300 rounded-lg border border-midnight-700 hover:border-accent-500 hover:text-accent-400 transition-all">Weekly</button>
                            </div>

                            <!-- Cron Input -->
                            <div class="relative">
                                <div class="bg-midnight-950 rounded-lg border border-midnight-700 p-4">
                                    <div class="flex items-center justify-center gap-2 font-mono text-2xl">
                                        <input type="text" name="cron_minute" id="cron_minute" value="{{ old('cron_minute', '*') }}" 
                                               class="w-16 h-12 bg-midnight-800 border border-midnight-600 rounded-lg text-center text-midnight-100 text-xl focus:border-accent-500 focus:outline-none focus:ring-1 focus:ring-accent-500 transition-colors" 
                                               placeholder="*" oninput="updateCronExpression()">
                                        <input type="text" name="cron_hour" id="cron_hour" value="{{ old('cron_hour', '*') }}" 
                                               class="w-16 h-12 bg-midnight-800 border border-midnight-600 rounded-lg text-center text-midnight-100 text-xl focus:border-accent-500 focus:outline-none focus:ring-1 focus:ring-accent-500 transition-colors" 
                                               placeholder="*" oninput="updateCronExpression()">
                                        <input type="text" name="cron_day" id="cron_day" value="{{ old('cron_day', '*') }}" 
                                               class="w-16 h-12 bg-midnight-800 border border-midnight-600 rounded-lg text-center text-midnight-100 text-xl focus:border-accent-500 focus:outline-none focus:ring-1 focus:ring-accent-500 transition-colors" 
                                               placeholder="*" oninput="updateCronExpression()">
                                        <input type="text" name="cron_month" id="cron_month" value="{{ old('cron_month', '*') }}" 
                                               class="w-16 h-12 bg-midnight-800 border border-midnight-600 rounded-lg text-center text-midnight-100 text-xl focus:border-accent-500 focus:outline-none focus:ring-1 focus:ring-accent-500 transition-colors" 
                                               placeholder="*" oninput="updateCronExpression()">
                                        <input type="text" name="cron_weekday" id="cron_weekday" value="{{ old('cron_weekday', '*') }}" 
                                               class="w-16 h-12 bg-midnight-800 border border-midnight-600 rounded-lg text-center text-midnight-100 text-xl focus:border-accent-500 focus:outline-none focus:ring-1 focus:ring-accent-500 transition-colors" 
                                               placeholder="*" oninput="updateCronExpression()">
                                    </div>
                                    <!-- Field Labels -->
                                    <div class="flex items-center justify-center gap-2 mt-3 text-xs text-midnight-500 font-mono">
                                        <span class="w-16 text-center">minute</span>
                                        <span class="w-16 text-center">hour</span>
                                        <span class="w-16 text-center">day</span>
                                        <span class="w-16 text-center">month</span>
                                        <span class="w-16 text-center">weekday</span>
                                    </div>
                                </div>
                                <input type="hidden" name="cron_expression" id="cron_expression" value="{{ old('cron_expression', '* * * * *') }}">
                            </div>

                            <!-- Human Readable Description -->
                            <div class="mt-4 p-4 bg-midnight-800/50 rounded-lg border border-midnight-700">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-accent-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-lg font-medium text-midnight-100" id="cron-description">Every minute</p>
                                        <p class="text-sm text-midnight-500" id="cron-expression-display">* * * * *</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Next Executions -->
                            <div class="mt-4">
                                <p class="text-xs text-midnight-500 mb-2">Next scheduled runs:</p>
                                <div class="flex flex-wrap gap-2" id="next-executions">
                                    <span class="px-3 py-1 bg-midnight-800 rounded-full text-sm text-midnight-300">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <button type="submit" class="btn-primary w-full sm:w-auto text-lg px-8 py-4">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Test This Job — Free
                            </button>
                            <p class="text-sm text-midnight-500">
                                <svg class="w-4 h-4 inline mr-1 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                No signup required • Test run included
                            </p>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Trust Badges -->
            <div class="flex items-center justify-center gap-8 mt-12 pt-8 border-t border-midnight-800/50">
                <div class="text-center">
                    <p class="text-2xl font-bold text-midnight-50">99.9%</p>
                    <p class="text-sm text-midnight-500">Uptime</p>
                </div>
                <div class="w-px h-10 bg-midnight-800"></div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-midnight-50">1M+</p>
                    <p class="text-sm text-midnight-500">Jobs Executed</p>
                </div>
                <div class="w-px h-10 bg-midnight-800"></div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-midnight-50">&lt;100ms</p>
                    <p class="text-sm text-midnight-500">Avg Latency</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-midnight-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-midnight-50 mb-4">Everything you need for job scheduling</h2>
                <p class="text-midnight-400 max-w-2xl mx-auto">
                    Powerful features to help you monitor and manage your scheduled HTTP tasks with ease.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="card-hover p-6">
                    <div class="w-12 h-12 bg-accent-500/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-midnight-50 mb-2">Flexible Scheduling</h3>
                    <p class="text-midnight-400 text-sm">
                        Set up jobs with intervals, daily/weekly schedules, or custom cron expressions. Full timezone support included.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="card-hover p-6">
                    <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-midnight-50 mb-2">Automatic Retries</h3>
                    <p class="text-midnight-400 text-sm">
                        Failed jobs are automatically retried based on your configuration. Never miss a critical task again.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="card-hover p-6">
                    <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-midnight-50 mb-2">Instant Alerts</h3>
                    <p class="text-midnight-400 text-sm">
                        Get notified immediately when your jobs fail. Email notifications with detailed error information.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="card-hover p-6">
                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-midnight-50 mb-2">Detailed Logs</h3>
                    <p class="text-midnight-400 text-sm">
                        View complete execution history with response times, status codes, and response snippets for debugging.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="card-hover p-6">
                    <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-midnight-50 mb-2">Custom Headers & Body</h3>
                    <p class="text-midnight-400 text-sm">
                        Full control over your HTTP requests. Add custom headers, set request bodies, and choose your method.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="card-hover p-6">
                    <div class="w-12 h-12 bg-amber-500/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-midnight-50 mb-2">Timezone Support</h3>
                    <p class="text-midnight-400 text-sm">
                        Schedule jobs in your local timezone. We handle all the time conversion automatically.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-midnight-50 mb-4">How it works</h2>
                <p class="text-midnight-400">Get started in 3 simple steps</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-accent-500 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold text-midnight-950">1</div>
                    <h3 class="text-xl font-semibold text-midnight-50 mb-2">Create Your Job</h3>
                    <p class="text-midnight-400">Enter your URL and set your schedule using our visual cron builder above.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-accent-500 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold text-midnight-950">2</div>
                    <h3 class="text-xl font-semibold text-midnight-50 mb-2">Sign Up Free</h3>
                    <p class="text-midnight-400">Create your account to activate monitoring and receive alerts.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-accent-500 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold text-midnight-950">3</div>
                    <h3 class="text-xl font-semibold text-midnight-50 mb-2">Monitor & Relax</h3>
                    <p class="text-midnight-400">We'll run your jobs and notify you if anything goes wrong.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-midnight-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-12 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-accent-500/10 via-transparent to-accent-500/10"></div>
                
                <div class="relative">
                    <h2 class="text-3xl font-bold text-midnight-50 mb-4">Ready to automate your tasks?</h2>
                    <p class="text-midnight-400 mb-8 max-w-xl mx-auto">
                        Join thousands of developers who trust cronjobs.to for their scheduled tasks.
                    </p>
                    <a href="#" onclick="document.getElementById('url').focus(); window.scrollTo({top: 0, behavior: 'smooth'}); return false;" class="btn-primary text-base px-8 py-3">
                        Create Your First Job
                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Cron Expression JavaScript -->
    <script>
    const cronDescriptions = {
        '* * * * *': 'Every minute',
        '*/5 * * * *': 'Every 5 minutes',
        '*/10 * * * *': 'Every 10 minutes',
        '*/15 * * * *': 'Every 15 minutes',
        '*/30 * * * *': 'Every 30 minutes',
        '0 * * * *': 'Every hour',
        '0 */2 * * *': 'Every 2 hours',
        '0 */3 * * *': 'Every 3 hours',
        '0 */6 * * *': 'Every 6 hours',
        '0 */12 * * *': 'Every 12 hours',
        '0 0 * * *': 'Every day at midnight',
        '0 12 * * *': 'Every day at noon',
        '0 0 * * 0': 'Every Sunday at midnight',
        '0 0 * * 1': 'Every Monday at midnight',
        '0 0 1 * *': 'First day of every month',
        '0 0 1 1 *': 'Every year on January 1st',
    };

    function setCronPreset(expression, description) {
        const parts = expression.split(' ');
        document.getElementById('cron_minute').value = parts[0];
        document.getElementById('cron_hour').value = parts[1];
        document.getElementById('cron_day').value = parts[2];
        document.getElementById('cron_month').value = parts[3];
        document.getElementById('cron_weekday').value = parts[4];
        updateCronExpression();
    }

    function updateCronExpression() {
        const minute = document.getElementById('cron_minute').value || '*';
        const hour = document.getElementById('cron_hour').value || '*';
        const day = document.getElementById('cron_day').value || '*';
        const month = document.getElementById('cron_month').value || '*';
        const weekday = document.getElementById('cron_weekday').value || '*';
        
        const expression = `${minute} ${hour} ${day} ${month} ${weekday}`;
        document.getElementById('cron_expression').value = expression;
        document.getElementById('cron-expression-display').textContent = expression;
        
        // Update description
        const description = cronDescriptions[expression] || describeCron(minute, hour, day, month, weekday);
        document.getElementById('cron-description').textContent = description;
        
        // Update next executions
        updateNextExecutions(expression);
    }

    function describeCron(minute, hour, day, month, weekday) {
        let desc = '';
        
        // Simple descriptions
        if (minute.startsWith('*/')) {
            return `Every ${minute.slice(2)} minutes`;
        }
        if (minute === '0' && hour.startsWith('*/')) {
            return `Every ${hour.slice(2)} hours`;
        }
        if (minute === '0' && hour === '0') {
            if (day === '*' && month === '*' && weekday === '*') return 'Every day at midnight';
            if (day === '*' && month === '*') {
                const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                if (!isNaN(weekday)) return `Every ${days[weekday]} at midnight`;
            }
        }
        if (minute !== '*' && hour !== '*' && day === '*' && month === '*' && weekday === '*') {
            return `Daily at ${hour.padStart(2, '0')}:${minute.padStart(2, '0')}`;
        }
        
        return `Custom schedule: ${minute} ${hour} ${day} ${month} ${weekday}`;
    }

    function updateNextExecutions(expression) {
        const container = document.getElementById('next-executions');
        const timezone = document.getElementById('timezone').value;
        
        // Simple next execution calculation (client-side approximation)
        const now = new Date();
        const executions = [];
        
        try {
            for (let i = 0; i < 5; i++) {
                const next = getNextExecution(expression, now, i);
                if (next) {
                    executions.push(formatDate(next, timezone));
                }
            }
        } catch (e) {
            executions.push('Invalid expression');
        }
        
        container.innerHTML = executions.map(e => 
            `<span class="px-3 py-1 bg-midnight-800 rounded-full text-sm text-midnight-300">${e}</span>`
        ).join('');
    }

    function getNextExecution(expression, fromDate, offset = 0) {
        const parts = expression.split(' ');
        const minute = parts[0];
        const hour = parts[1];
        
        let next = new Date(fromDate);
        next.setSeconds(0);
        next.setMilliseconds(0);
        
        // Simple interval calculation
        if (minute.startsWith('*/')) {
            const interval = parseInt(minute.slice(2));
            const currentMinute = next.getMinutes();
            const nextMinute = Math.ceil((currentMinute + 1) / interval) * interval;
            next.setMinutes(nextMinute);
            next.setMinutes(next.getMinutes() + (offset * interval));
        } else if (minute === '0' && hour.startsWith('*/')) {
            const interval = parseInt(hour.slice(2));
            next.setMinutes(0);
            const currentHour = next.getHours();
            const nextHour = Math.ceil((currentHour + 1) / interval) * interval;
            next.setHours(nextHour);
            next.setHours(next.getHours() + (offset * interval));
        } else {
            // Daily at specific time
            const targetMinute = minute === '*' ? 0 : parseInt(minute);
            const targetHour = hour === '*' ? 0 : parseInt(hour);
            next.setMinutes(targetMinute);
            next.setHours(targetHour);
            if (next <= fromDate) {
                next.setDate(next.getDate() + 1);
            }
            next.setDate(next.getDate() + offset);
        }
        
        return next;
    }

    function formatDate(date, timezone) {
        return date.toLocaleDateString('en-US', {
            weekday: 'short',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            timeZone: timezone
        });
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Set default to every 15 minutes
        setCronPreset('*/15 * * * *', 'Every 15 minutes');
        
        // Update on timezone change
        document.getElementById('timezone').addEventListener('change', function() {
            updateCronExpression();
        });
    });
    </script>

</x-public-layout>
