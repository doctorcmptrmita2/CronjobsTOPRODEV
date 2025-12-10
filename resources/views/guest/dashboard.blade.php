<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Preview Dashboard - {{ config('app.name', 'Cronjobs.to') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-midnight-950 text-midnight-100 antialiased">
    <!-- Top Banner -->
    <div class="bg-gradient-to-r from-accent-500 to-amber-600 text-midnight-950 py-3 px-4">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <span class="font-semibold">Preview Mode</span>
                <span class="hidden sm:inline">— You're testing Cronjobs.to without an account</span>
            </div>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-midnight-900 text-accent-400 px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-midnight-800 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Create Free Account
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="min-h-screen py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-2xl font-bold text-accent-500">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Cronjobs.to
                </a>
                <p class="text-midnight-400 mt-2">Preview Dashboard</p>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-lg text-green-400 flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg text-red-400 flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Job Card -->
            <div class="card p-6 mb-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h1 class="text-xl font-bold text-midnight-50 flex items-center gap-3">
                            <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-accent-500/10">
                                <svg class="w-5 h-5 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </span>
                            {{ $job['name'] }}
                        </h1>
                        <p class="text-midnight-400 mt-1 font-mono text-sm break-all">{{ $job['url'] }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400">
                        Preview
                    </span>
                </div>

                <!-- Job Details Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-midnight-800/50 rounded-lg p-4">
                        <p class="text-xs text-midnight-500 uppercase tracking-wider mb-1">Method</p>
                        <p class="font-mono font-semibold text-midnight-100">{{ $job['http_method'] }}</p>
                    </div>
                    <div class="bg-midnight-800/50 rounded-lg p-4">
                        <p class="text-xs text-midnight-500 uppercase tracking-wider mb-1">Schedule</p>
                        <p class="font-mono font-semibold text-midnight-100">{{ $job['cron_expression'] }}</p>
                    </div>
                    <div class="bg-midnight-800/50 rounded-lg p-4">
                        <p class="text-xs text-midnight-500 uppercase tracking-wider mb-1">Timezone</p>
                        <p class="font-semibold text-midnight-100">{{ $job['timezone'] }}</p>
                    </div>
                    <div class="bg-midnight-800/50 rounded-lg p-4">
                        <p class="text-xs text-midnight-500 uppercase tracking-wider mb-1">Expected Status</p>
                        <p class="font-semibold text-midnight-100">{{ $job['expected_status_from'] }}-{{ $job['expected_status_to'] }}</p>
                    </div>
                </div>

                <!-- Test Run Section -->
                <div class="border-t border-midnight-700 pt-6">
                    <h2 class="text-lg font-semibold text-midnight-100 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Test Run
                    </h2>

                    @if($testResult)
                        <!-- Test Result -->
                        <div class="bg-midnight-800/50 rounded-lg overflow-hidden">
                            <div class="p-4 border-b border-midnight-700 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    @if($testResult['success'])
                                        <span class="flex items-center justify-center w-10 h-10 rounded-full bg-green-500/20">
                                            <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    @else
                                        <span class="flex items-center justify-center w-10 h-10 rounded-full bg-red-500/20">
                                            <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </span>
                                    @endif
                                    <div>
                                        <p class="font-semibold {{ $testResult['success'] ? 'text-green-400' : 'text-red-400' }}">
                                            @if($testResult['success'])
                                                Success
                                            @else
                                                Failed
                                            @endif
                                        </p>
                                        <p class="text-xs text-midnight-500">
                                            {{ \Carbon\Carbon::parse($testResult['ran_at'])->format('M d, Y H:i:s') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 text-sm">
                                    @if($testResult['status_code'])
                                        <div class="text-center">
                                            <p class="text-midnight-500 text-xs">Status</p>
                                            <p class="font-mono font-semibold {{ $testResult['success'] ? 'text-green-400' : 'text-red-400' }}">
                                                {{ $testResult['status_code'] }}
                                            </p>
                                        </div>
                                    @endif
                                    <div class="text-center">
                                        <p class="text-midnight-500 text-xs">Duration</p>
                                        <p class="font-mono font-semibold text-midnight-100">{{ $testResult['duration_ms'] }}ms</p>
                                    </div>
                                </div>
                            </div>

                            @if($testResult['error_message'])
                                <div class="p-4 border-b border-midnight-700">
                                    <p class="text-xs text-midnight-500 uppercase tracking-wider mb-2">Error Message</p>
                                    <p class="text-red-400 font-mono text-sm">{{ $testResult['error_message'] }}</p>
                                </div>
                            @endif

                            @if($testResult['response_snippet'])
                                <div class="p-4">
                                    <p class="text-xs text-midnight-500 uppercase tracking-wider mb-2">Response Preview</p>
                                    <pre class="bg-midnight-950 rounded-lg p-4 text-sm text-midnight-300 font-mono overflow-x-auto max-h-48">{{ $testResult['response_snippet'] }}</pre>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 p-4 bg-accent-500/10 border border-accent-500/30 rounded-lg">
                            <p class="text-accent-400 text-sm flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                You've used your free test run. Create an account to run unlimited tests and enable automatic monitoring!
                            </p>
                        </div>
                    @else
                        <!-- Test Run Button -->
                        <div class="bg-midnight-800/30 rounded-lg p-6 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-accent-500/10 flex items-center justify-center">
                                <svg class="w-8 h-8 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-midnight-100 mb-2">Ready to Test?</h3>
                            <p class="text-midnight-400 mb-4 max-w-md mx-auto">
                                Run a test to see how your endpoint responds. You get <strong class="text-accent-400">1 free test run</strong> in preview mode.
                            </p>
                            <form action="{{ route('guest.test-run') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-primary">
                                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    </svg>
                                    Run Test Now
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Next Scheduled Runs Preview -->
            <div class="card p-6 mb-6">
                <h2 class="text-lg font-semibold text-midnight-100 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Next Scheduled Runs
                </h2>
                <div class="flex flex-wrap gap-2" id="next-runs-container">
                    <span class="px-3 py-1.5 bg-midnight-800 rounded-lg text-sm text-midnight-300">Loading...</span>
                </div>
                <p class="text-xs text-midnight-500 mt-3">
                    * Times shown in {{ $job['timezone'] }}
                </p>
            </div>

            <!-- CTA Section -->
            <div class="card p-8 text-center bg-gradient-to-br from-midnight-900 via-midnight-900 to-accent-900/20">
                <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-accent-500 to-amber-500 flex items-center justify-center">
                    <svg class="w-10 h-10 text-midnight-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-midnight-50 mb-3">Ready to Save Your Job?</h2>
                <p class="text-midnight-400 mb-6 max-w-lg mx-auto">
                    Create a free account to save this job, enable automatic monitoring, get instant failure alerts, and view detailed execution logs.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <form action="{{ route('guest.save-job') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary text-lg px-8 py-3">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Save This Job — It's Free
                        </button>
                    </form>
                    <a href="{{ route('landing') }}" class="text-midnight-400 hover:text-midnight-200 transition-colors">
                        Start Over
                    </a>
                </div>

                <!-- Benefits -->
                <div class="mt-8 pt-8 border-t border-midnight-700 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div class="text-center">
                        <svg class="w-6 h-6 mx-auto text-green-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-midnight-300">Free Forever Plan</p>
                    </div>
                    <div class="text-center">
                        <svg class="w-6 h-6 mx-auto text-green-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-midnight-300">Up to 5 Jobs</p>
                    </div>
                    <div class="text-center">
                        <svg class="w-6 h-6 mx-auto text-green-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-midnight-300">Email Alerts</p>
                    </div>
                    <div class="text-center">
                        <svg class="w-6 h-6 mx-auto text-green-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-midnight-300">No Credit Card</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/cronstrue@2.50.0/dist/cronstrue.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cronExpression = @json($job['cron_expression']);
            const timezone = @json($job['timezone']);

            // Calculate next runs
            function getNextRuns(cron, count = 5) {
                const runs = [];
                let date = new Date();

                for (let i = 0; i < count && i < 100; i++) {
                    date = getNextCronDate(cron, new Date(date.getTime() + 60000));
                    if (date) {
                        runs.push(date);
                    }
                }
                return runs;
            }

            // Simple cron parser for display purposes
            function getNextCronDate(cron, fromDate) {
                const parts = cron.split(' ');
                if (parts.length !== 5) return null;

                const [minute, hour, day, month, weekday] = parts;
                let date = new Date(fromDate);

                // Simple implementation - just add intervals based on pattern
                for (let i = 0; i < 1440; i++) { // Check up to 24 hours
                    date = new Date(date.getTime() + 60000); // Add 1 minute

                    if (matchesCron(date, minute, hour, day, month, weekday)) {
                        return date;
                    }
                }
                return null;
            }

            function matchesCron(date, minute, hour, day, month, weekday) {
                return matchField(date.getMinutes(), minute) &&
                       matchField(date.getHours(), hour) &&
                       matchField(date.getDate(), day) &&
                       matchField(date.getMonth() + 1, month) &&
                       matchField(date.getDay(), weekday);
            }

            function matchField(value, field) {
                if (field === '*') return true;
                if (field.includes('/')) {
                    const [, step] = field.split('/');
                    return value % parseInt(step) === 0;
                }
                if (field.includes(',')) {
                    return field.split(',').map(Number).includes(value);
                }
                if (field.includes('-')) {
                    const [start, end] = field.split('-').map(Number);
                    return value >= start && value <= end;
                }
                return parseInt(field) === value;
            }

            // Display next runs
            const container = document.getElementById('next-runs-container');
            const nextRuns = getNextRuns(cronExpression, 5);

            if (nextRuns.length > 0) {
                container.innerHTML = nextRuns.map(date => {
                    const formatted = date.toLocaleString('en-US', {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        timeZone: timezone === 'UTC' ? 'UTC' : undefined
                    });
                    return `<span class="px-3 py-1.5 bg-midnight-800 rounded-lg text-sm text-midnight-300 font-mono">${formatted}</span>`;
                }).join('');
            } else {
                container.innerHTML = '<span class="text-midnight-500">Could not calculate next runs</span>';
            }
        });
    </script>
</body>
</html>

