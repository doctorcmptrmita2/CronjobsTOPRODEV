<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('jobs.index') }}" class="p-2 text-midnight-400 hover:text-midnight-100 hover:bg-midnight-800 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-bold text-midnight-50">{{ $job->name }}</h1>
                        @if($job->is_active)
                        <span class="badge-success">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5 animate-pulse"></span>
                            Active
                        </span>
                        @else
                        <span class="badge-neutral">Paused</span>
                        @endif
                    </div>
                    <p class="text-sm text-midnight-400 mt-1 font-mono">{{ $job->url }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <form action="{{ route('jobs.run-now', $job) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Run Now
                    </button>
                </form>
                <a href="{{ route('jobs.edit', $job) }}" class="btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <form action="{{ route('jobs.destroy', $job) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this job?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <p class="stat-card-label">Method</p>
            <p class="stat-card-value text-lg font-mono text-accent-400">{{ $job->http_method }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Schedule</p>
            <p class="stat-card-value text-lg">{{ $job->schedule_summary }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Last Run</p>
            <p class="stat-card-value text-lg">
                @if($job->last_run_at)
                {{ $job->last_run_at->diffForHumans() }}
                @else
                <span class="text-midnight-500">Never</span>
                @endif
            </p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Next Run</p>
            <p class="stat-card-value text-lg">
                @if($job->next_run_at && $job->is_active)
                {{ $job->next_run_at->diffForHumans() }}
                @else
                <span class="text-midnight-500">—</span>
                @endif
            </p>
        </div>
    </div>

    <!-- Job Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 card p-6">
            <h3 class="text-lg font-semibold text-midnight-50 mb-4">Configuration</h3>
            <dl class="grid grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm text-midnight-500">Timeout</dt>
                    <dd class="text-midnight-100 font-mono">{{ $job->timeout_seconds }}s</dd>
                </div>
                <div>
                    <dt class="text-sm text-midnight-500">Expected Status</dt>
                    <dd class="text-midnight-100 font-mono">{{ $job->expected_status_from }} - {{ $job->expected_status_to }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-midnight-500">Max Retries</dt>
                    <dd class="text-midnight-100">{{ $job->max_retries }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-midnight-500">Timezone</dt>
                    <dd class="text-midnight-100">{{ $job->timezone }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-midnight-500">Alert Threshold</dt>
                    <dd class="text-midnight-100">{{ $job->failure_alert_threshold }} failures</dd>
                </div>
                <div>
                    <dt class="text-sm text-midnight-500">Consecutive Failures</dt>
                    <dd class="{{ $job->consecutive_failures > 0 ? 'text-red-400' : 'text-emerald-400' }}">
                        {{ $job->consecutive_failures }}
                    </dd>
                </div>
            </dl>
            
            @if($job->description)
            <div class="mt-6 pt-6 border-t border-midnight-800">
                <h4 class="text-sm text-midnight-500 mb-2">Description</h4>
                <p class="text-midnight-300">{{ $job->description }}</p>
            </div>
            @endif
            
            @if($job->headers_json)
            <div class="mt-6 pt-6 border-t border-midnight-800">
                <h4 class="text-sm text-midnight-500 mb-2">Headers</h4>
                <pre class="text-sm text-midnight-300 font-mono bg-midnight-950 rounded-lg p-4 overflow-x-auto">{{ json_encode(json_decode($job->headers_json), JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif
        </div>
        
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-midnight-50 mb-4">Last Run Details</h3>
            @if($job->last_run_at)
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm text-midnight-500">Status Code</dt>
                    <dd class="text-2xl font-mono {{ $job->last_status_code >= 200 && $job->last_status_code < 300 ? 'text-emerald-400' : 'text-red-400' }}">
                        {{ $job->last_status_code }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm text-midnight-500">Duration</dt>
                    <dd class="text-midnight-100 font-mono">{{ $job->last_duration_ms }}ms</dd>
                </div>
                <div>
                    <dt class="text-sm text-midnight-500">Ran At</dt>
                    <dd class="text-midnight-100">{{ $job->last_run_at->format('M d, Y H:i:s') }}</dd>
                </div>
                @if($job->last_error_message)
                <div>
                    <dt class="text-sm text-midnight-500">Error</dt>
                    <dd class="text-red-400 text-sm">{{ $job->last_error_message }}</dd>
                </div>
                @endif
            </dl>
            @else
            <p class="text-midnight-500">No runs yet</p>
            @endif
        </div>
    </div>

    <!-- Recent Runs -->
    <div class="card">
        <div class="px-6 py-4 border-b border-midnight-800">
            <h3 class="text-lg font-semibold text-midnight-50">Run History</h3>
        </div>
        
        @if($runs->isEmpty())
        <div class="px-6 py-12 text-center">
            <p class="text-midnight-500">No runs recorded yet</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ran at</th>
                        <th>Status</th>
                        <th>Duration</th>
                        <th>Result</th>
                        <th>Error</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($runs as $run)
                    <tr>
                        <td class="font-mono text-xs text-midnight-400">
                            {{ $run->ran_at->format('M d, Y H:i:s') }}
                        </td>
                        <td>
                            <span class="font-mono text-sm {{ $run->status_code >= 200 && $run->status_code < 300 ? 'text-emerald-400' : 'text-red-400' }}">
                                {{ $run->status_code ?? '—' }}
                            </span>
                        </td>
                        <td class="font-mono text-xs text-midnight-400">
                            {{ $run->duration_ms ? $run->duration_ms . 'ms' : '—' }}
                        </td>
                        <td>
                            @if($run->success)
                            <span class="badge-success">Success</span>
                            @else
                            <span class="badge-danger">Failed</span>
                            @endif
                        </td>
                        <td class="text-sm text-red-400 max-w-xs truncate">
                            {{ $run->error_message ?? '—' }}
                        </td>
                        <td>
                            <a href="{{ route('jobs.runs.show', [$job, $run]) }}" class="text-accent-500 hover:text-accent-400 text-sm">
                                Details →
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($runs->hasPages())
        <div class="px-6 py-4 border-t border-midnight-800">
            {{ $runs->links() }}
        </div>
        @endif
        @endif
    </div>
</x-app-layout>
