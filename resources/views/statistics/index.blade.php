<x-app-layout>
    <x-slot name="title">Statistics</x-slot>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-midnight-50">Statistics</h1>
                <p class="text-sm text-midnight-400 mt-1">Monitor your job performance and trends</p>
            </div>
            
            <!-- Period Selector -->
            <div class="flex items-center gap-2">
                @foreach(['24h' => 'Last 24h', '7d' => 'Last 7 days', '30d' => 'Last 30 days', '90d' => 'Last 90 days'] as $key => $label)
                <a href="{{ route('statistics', ['period' => $key]) }}" 
                   class="px-4 py-2 text-sm font-medium rounded-lg transition-all
                          {{ $period === $key 
                             ? 'bg-accent-500 text-midnight-950' 
                             : 'bg-midnight-800 text-midnight-300 border border-midnight-700 hover:border-midnight-600' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>
        </div>
    </x-slot>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-card-label">Total Runs</p>
                    <p class="stat-card-value">{{ number_format($totalRuns) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-card-label">Successful</p>
                    <p class="stat-card-value text-emerald-400">{{ number_format($successfulRuns) }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-card-label">Failed</p>
                    <p class="stat-card-value text-red-400">{{ number_format($failedRuns) }}</p>
                </div>
                <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-card-label">Avg Response Time</p>
                    <p class="stat-card-value">{{ number_format($avgResponseTime) }}<span class="text-lg text-midnight-500">ms</span></p>
                </div>
                <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Rate -->
    <div class="card p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-midnight-50">Success Rate</h3>
            <span class="text-3xl font-bold {{ $successRate >= 90 ? 'text-emerald-400' : ($successRate >= 70 ? 'text-amber-400' : 'text-red-400') }}">
                {{ $successRate }}%
            </span>
        </div>
        <div class="w-full bg-midnight-800 rounded-full h-4 overflow-hidden">
            <div class="h-full rounded-full transition-all duration-500 {{ $successRate >= 90 ? 'bg-emerald-500' : ($successRate >= 70 ? 'bg-amber-500' : 'bg-red-500') }}"
                 style="width: {{ $successRate }}%"></div>
        </div>
        <div class="flex justify-between mt-2 text-sm text-midnight-500">
            <span>0%</span>
            <span>50%</span>
            <span>100%</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Daily Activity Chart -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-midnight-50 mb-6">Daily Activity</h3>
            @if($dailyStats->isEmpty())
            <div class="text-center py-8">
                <p class="text-midnight-500">No activity data available</p>
            </div>
            @else
            <div class="space-y-3">
                @foreach($dailyStats as $day)
                @php
                    $maxRuns = $dailyStats->max('total') ?: 1;
                    $percentage = ($day->total / $maxRuns) * 100;
                    $successPercentage = $day->total > 0 ? ($day->successful / $day->total) * 100 : 0;
                @endphp
                <div class="flex items-center gap-4">
                    <span class="text-xs text-midnight-500 w-20">{{ \Carbon\Carbon::parse($day->date)->format('M d') }}</span>
                    <div class="flex-1 h-6 bg-midnight-800 rounded overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-600 rounded transition-all"
                             style="width: {{ $percentage }}%"></div>
                    </div>
                    <span class="text-sm text-midnight-300 w-16 text-right">{{ $day->total }} runs</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Status Code Distribution -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-midnight-50 mb-6">Status Codes</h3>
            @if($statusCodes->isEmpty())
            <div class="text-center py-8">
                <p class="text-midnight-500">No status code data available</p>
            </div>
            @else
            <div class="space-y-3">
                @foreach($statusCodes as $status)
                @php
                    $maxCount = $statusCodes->max('count') ?: 1;
                    $percentage = ($status->count / $maxCount) * 100;
                    $color = $status->status_code >= 200 && $status->status_code < 300 ? 'emerald' : 
                            ($status->status_code >= 400 && $status->status_code < 500 ? 'amber' : 'red');
                @endphp
                <div class="flex items-center gap-4">
                    <span class="font-mono text-sm text-{{ $color }}-400 w-12">{{ $status->status_code }}</span>
                    <div class="flex-1 h-6 bg-midnight-800 rounded overflow-hidden">
                        <div class="h-full bg-{{ $color }}-500/50 rounded transition-all"
                             style="width: {{ $percentage }}%"></div>
                    </div>
                    <span class="text-sm text-midnight-300 w-16 text-right">{{ number_format($status->count) }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- Per-Job Stats -->
    <div class="card">
        <div class="px-6 py-4 border-b border-midnight-800">
            <h3 class="text-lg font-semibold text-midnight-50">Per-Job Statistics</h3>
        </div>
        
        @if($jobStats->isEmpty())
        <div class="px-6 py-12 text-center">
            <p class="text-midnight-500">No jobs found. Create your first job to see statistics.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Job</th>
                        <th>Total Runs</th>
                        <th>Successful</th>
                        <th>Success Rate</th>
                        <th>Avg Duration</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobStats as $job)
                    @php
                        $jobSuccessRate = $job->total_runs > 0 
                            ? round(($job->successful_runs / $job->total_runs) * 100, 1) 
                            : 0;
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('jobs.show', $job) }}" class="text-midnight-100 hover:text-accent-400 font-medium">
                                {{ $job->name }}
                            </a>
                        </td>
                        <td class="text-midnight-300">{{ number_format($job->total_runs) }}</td>
                        <td class="text-emerald-400">{{ number_format($job->successful_runs) }}</td>
                        <td>
                            <span class="{{ $jobSuccessRate >= 90 ? 'text-emerald-400' : ($jobSuccessRate >= 70 ? 'text-amber-400' : 'text-red-400') }}">
                                {{ $jobSuccessRate }}%
                            </span>
                        </td>
                        <td class="font-mono text-sm text-midnight-400">
                            {{ $job->avg_duration ? round($job->avg_duration) . 'ms' : '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-app-layout>

