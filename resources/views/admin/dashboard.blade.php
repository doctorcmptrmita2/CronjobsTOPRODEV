<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-midnight-50">Admin Dashboard</h1>
        <p class="text-sm text-midnight-400 mt-1">System overview and metrics</p>
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="stat-card">
            <p class="stat-card-label">Total Users</p>
            <p class="stat-card-value">{{ number_format($totalUsers) }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Total Jobs</p>
            <p class="stat-card-value">{{ number_format($totalJobs) }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Active Jobs</p>
            <p class="stat-card-value text-emerald-400">{{ number_format($activeJobs) }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Runs (24h)</p>
            <p class="stat-card-value">{{ number_format($runsLast24h) }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Failures (24h)</p>
            <p class="stat-card-value text-red-400">{{ number_format($failedRunsLast24h) }}</p>
        </div>
    </div>

    <!-- Top Failing Jobs -->
    <div class="card">
        <div class="px-6 py-4 border-b border-midnight-800">
            <h2 class="text-lg font-semibold text-midnight-50">Top Failing Jobs (24h)</h2>
        </div>
        
        @if($topFailingJobs->isEmpty())
        <div class="px-6 py-12 text-center">
            <div class="w-16 h-16 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-midnight-400">No failures in the last 24 hours. Great job! 🎉</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Job</th>
                        <th>User</th>
                        <th>Failures</th>
                        <th>Last Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topFailingJobs as $job)
                    <tr>
                        <td class="font-medium text-midnight-100">{{ $job->name }}</td>
                        <td class="text-midnight-400">{{ $job->user->email }}</td>
                        <td>
                            <span class="badge-danger">{{ $job->failure_count }} failures</span>
                        </td>
                        <td class="font-mono text-red-400">{{ $job->last_status_code ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-app-layout>
