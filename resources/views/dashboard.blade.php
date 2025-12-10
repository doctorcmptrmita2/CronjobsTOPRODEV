<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-midnight-50">Dashboard</h1>
                <p class="text-sm text-midnight-400 mt-1">Overview of your scheduled jobs and recent activity</p>
            </div>
            <a href="{{ route('jobs.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Job
            </a>
        </div>
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Jobs -->
        <div class="stat-card group hover:border-midnight-700 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-card-label">Total Jobs</p>
                    <p class="stat-card-value">{{ $totalJobs }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center group-hover:bg-blue-500/20 transition-colors">
                    <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Jobs -->
        <div class="stat-card group hover:border-midnight-700 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-card-label">Active Jobs</p>
                    <p class="stat-card-value text-emerald-400">{{ $activeJobs }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center group-hover:bg-emerald-500/20 transition-colors">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Runs (24h) -->
        <div class="stat-card group hover:border-midnight-700 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-card-label">Runs (24h)</p>
                    <p class="stat-card-value">{{ $runsLast24h }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-500/10 rounded-xl flex items-center justify-center group-hover:bg-accent-500/20 transition-colors">
                    <svg class="w-6 h-6 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Success Rate -->
        <div class="stat-card group hover:border-midnight-700 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-card-label">Success Rate (24h)</p>
                    <p class="stat-card-value {{ $successRate >= 90 ? 'text-emerald-400' : ($successRate >= 70 ? 'text-amber-400' : 'text-red-400') }}">
                        {{ number_format($successRate, 1) }}%
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center group-hover:bg-purple-500/20 transition-colors">
                    <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Runs -->
    <div class="card">
        <div class="px-6 py-4 border-b border-midnight-800 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-midnight-50">Recent Runs</h2>
            <a href="{{ route('jobs.index') }}" class="text-sm text-accent-500 hover:text-accent-400 transition-colors">
                View all jobs →
            </a>
        </div>
        
        @if($recentRuns->isEmpty())
        <div class="px-6 py-12 text-center">
            <div class="w-16 h-16 bg-midnight-800 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-midnight-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-midnight-400 mb-4">No runs yet. Create your first job to get started.</p>
            <a href="{{ route('jobs.create') }}" class="btn-primary">
                Create Job
            </a>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Job</th>
                        <th>Ran at</th>
                        <th>Status</th>
                        <th>Duration</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentRuns as $run)
                    <tr>
                        <td>
                            <a href="{{ route('jobs.show', $run->job) }}" class="text-midnight-100 hover:text-accent-400 transition-colors font-medium">
                                {{ $run->job->name }}
                            </a>
                        </td>
                        <td class="text-midnight-400 font-mono text-xs">
                            {{ $run->ran_at->format('M d, H:i:s') }}
                        </td>
                        <td>
                            <span class="font-mono text-sm {{ $run->status_code >= 200 && $run->status_code < 300 ? 'text-emerald-400' : 'text-red-400' }}">
                                {{ $run->status_code ?? '—' }}
                            </span>
                        </td>
                        <td class="text-midnight-400 font-mono text-xs">
                            {{ $run->duration_ms ? $run->duration_ms . 'ms' : '—' }}
                        </td>
                        <td>
                            @if($run->success)
                            <span class="badge-success">
                                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Success
                            </span>
                            @else
                            <span class="badge-danger">
                                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Failed
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-app-layout>
