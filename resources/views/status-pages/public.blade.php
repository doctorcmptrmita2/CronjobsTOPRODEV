<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $statusPage->name }} - Status</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⚡</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-midnight-950 text-midnight-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-midnight-50 mb-2">{{ $statusPage->name }}</h1>
            @if($statusPage->description)
            <p class="text-midnight-400">{{ $statusPage->description }}</p>
            @endif
        </div>

        <!-- Overall Status -->
        <div class="card p-8 mb-8 text-center">
            @if($overallStatus === 'operational')
            <div class="inline-flex items-center gap-3 px-6 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-full mb-4">
                <span class="w-3 h-3 bg-emerald-400 rounded-full animate-pulse"></span>
                <span class="text-emerald-400 font-semibold text-lg">All Systems Operational</span>
            </div>
            @elseif($overallStatus === 'degraded')
            <div class="inline-flex items-center gap-3 px-6 py-3 bg-amber-500/10 border border-amber-500/20 rounded-full mb-4">
                <span class="w-3 h-3 bg-amber-400 rounded-full animate-pulse"></span>
                <span class="text-amber-400 font-semibold text-lg">Partial System Outage</span>
            </div>
            @else
            <div class="inline-flex items-center gap-3 px-6 py-3 bg-red-500/10 border border-red-500/20 rounded-full mb-4">
                <span class="w-3 h-3 bg-red-400 rounded-full animate-pulse"></span>
                <span class="text-red-400 font-semibold text-lg">Major System Outage</span>
            </div>
            @endif
            <p class="text-sm text-midnight-500">Last updated: {{ now()->format('M d, Y H:i') }} UTC</p>
        </div>

        <!-- Services -->
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-midnight-800">
                <h2 class="text-lg font-semibold text-midnight-50">Services</h2>
            </div>
            
            <div class="divide-y divide-midnight-800">
                @forelse($jobs as $job)
                @php
                    $isOperational = $job->last_status_code >= 200 && $job->last_status_code < 300;
                    $hasIssues = $job->consecutive_failures > 0;
                @endphp
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            @if($isOperational && !$hasIssues)
                            <span class="w-3 h-3 bg-emerald-400 rounded-full"></span>
                            @elseif($hasIssues)
                            <span class="w-3 h-3 bg-amber-400 rounded-full"></span>
                            @else
                            <span class="w-3 h-3 bg-red-400 rounded-full"></span>
                            @endif
                            <span class="font-medium text-midnight-100">{{ $job->name }}</span>
                        </div>
                        <span class="text-sm {{ $isOperational && !$hasIssues ? 'text-emerald-400' : ($hasIssues ? 'text-amber-400' : 'text-red-400') }}">
                            {{ $isOperational && !$hasIssues ? 'Operational' : ($hasIssues ? 'Degraded' : 'Outage') }}
                        </span>
                    </div>

                    <!-- Uptime Chart (last 30 runs) -->
                    <div class="flex items-center gap-1">
                        @php
                            $runs = $job->runs->take(30)->reverse();
                        @endphp
                        @foreach($runs as $run)
                        <div class="flex-1 h-8 rounded {{ $run->success ? 'bg-emerald-500' : 'bg-red-500' }}" 
                             title="{{ $run->ran_at->format('M d, H:i') }} - {{ $run->success ? 'Success' : 'Failed' }}"></div>
                        @endforeach
                        @for($i = $runs->count(); $i < 30; $i++)
                        <div class="flex-1 h-8 rounded bg-midnight-800"></div>
                        @endfor
                    </div>
                    <div class="flex items-center justify-between mt-2 text-xs text-midnight-500">
                        <span>30 days ago</span>
                        <span>Today</span>
                    </div>
                </div>
                @empty
                <div class="p-12 text-center">
                    <p class="text-midnight-500">No services configured for this status page.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-12 text-sm text-midnight-500">
            <p>Powered by <a href="{{ url('/') }}" class="text-accent-500 hover:text-accent-400">Cronjobs.to</a></p>
        </div>
    </div>
</body>
</html>

