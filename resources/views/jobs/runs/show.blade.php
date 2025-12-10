<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('jobs.show', $job) }}" class="p-2 text-midnight-400 hover:text-midnight-100 hover:bg-midnight-800 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-midnight-50">Run Details</h1>
                <p class="text-sm text-midnight-400 mt-1">{{ $job->name }} • {{ $run->ran_at->format('M d, Y H:i:s') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status Card -->
            <div class="card p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-midnight-50">Execution Result</h3>
                    @if($run->success)
                    <span class="badge-success text-sm px-4 py-1">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Success
                    </span>
                    @else
                    <span class="badge-danger text-sm px-4 py-1">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Failed
                    </span>
                    @endif
                </div>

                <dl class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div>
                        <dt class="text-sm text-midnight-500 mb-1">Status Code</dt>
                        <dd class="text-2xl font-mono font-bold {{ $run->status_code >= 200 && $run->status_code < 300 ? 'text-emerald-400' : 'text-red-400' }}">
                            {{ $run->status_code ?? '—' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-midnight-500 mb-1">Duration</dt>
                        <dd class="text-2xl font-mono font-bold text-midnight-100">
                            {{ $run->duration_ms ? $run->duration_ms . 'ms' : '—' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-midnight-500 mb-1">Ran At</dt>
                        <dd class="text-midnight-100">
                            {{ $run->ran_at->format('M d, Y') }}<br>
                            <span class="text-sm text-midnight-400">{{ $run->ran_at->format('H:i:s') }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-midnight-500 mb-1">Method</dt>
                        <dd class="text-midnight-100 font-mono">{{ $job->http_method }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Error Message -->
            @if($run->error_message)
            <div class="card p-6 border-red-500/20">
                <h3 class="text-lg font-semibold text-red-400 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Error Message
                </h3>
                <pre class="bg-midnight-950 rounded-lg p-4 text-sm text-red-400 font-mono whitespace-pre-wrap overflow-x-auto">{{ $run->error_message }}</pre>
            </div>
            @endif

            <!-- Response Snippet -->
            @if($run->response_snippet)
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-midnight-50 mb-4">Response Body</h3>
                <pre class="bg-midnight-950 rounded-lg p-4 text-sm text-midnight-300 font-mono whitespace-pre-wrap overflow-x-auto max-h-96">{{ $run->response_snippet }}</pre>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Job Info -->
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-midnight-50 mb-4">Job Information</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm text-midnight-500">Name</dt>
                        <dd class="text-midnight-100 font-medium">{{ $job->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-midnight-500">URL</dt>
                        <dd class="text-midnight-300 font-mono text-sm break-all">{{ $job->url }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-midnight-500">Schedule</dt>
                        <dd class="text-midnight-100">{{ $job->schedule_summary }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-midnight-500">Expected Status</dt>
                        <dd class="text-midnight-100 font-mono">{{ $job->expected_status_from }} - {{ $job->expected_status_to }}</dd>
                    </div>
                </dl>
                
                <div class="mt-6 pt-6 border-t border-midnight-800">
                    <a href="{{ route('jobs.show', $job) }}" class="btn-secondary w-full justify-center text-sm">
                        View Job Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
