<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-midnight-50">All Jobs</h1>
                <p class="text-sm text-midnight-400 mt-1">View and manage all scheduled jobs</p>
            </div>
            
            <!-- Filters -->
            <form method="GET" class="flex items-center gap-3">
                <select name="status" onchange="this.form.submit()" class="select text-sm py-2">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="paused" {{ request('status') === 'paused' ? 'selected' : '' }}>Paused</option>
                </select>
                <label class="flex items-center gap-2 text-sm text-midnight-400">
                    <input type="checkbox" name="failing" value="1" {{ request('failing') ? 'checked' : '' }} onchange="this.form.submit()"
                           class="rounded border-midnight-700 bg-midnight-800 text-accent-500 focus:ring-accent-500">
                    Only failing
                </label>
            </form>
        </div>
    </x-slot>

    <div class="card">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Last Run</th>
                        <th>Failures</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                    <tr>
                        <td class="text-midnight-500 font-mono text-sm">{{ $job->id }}</td>
                        <td>
                            <p class="font-medium text-midnight-100">{{ $job->name }}</p>
                            <p class="text-xs text-midnight-500 font-mono truncate max-w-[200px]">{{ $job->url }}</p>
                        </td>
                        <td class="text-midnight-400">{{ $job->user->email }}</td>
                        <td>
                            @if($job->is_active)
                            <span class="badge-success">Active</span>
                            @else
                            <span class="badge-neutral">Paused</span>
                            @endif
                        </td>
                        <td>
                            @if($job->last_run_at)
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-sm {{ $job->last_status_code >= 200 && $job->last_status_code < 300 ? 'text-emerald-400' : 'text-red-400' }}">
                                    {{ $job->last_status_code }}
                                </span>
                                <span class="text-xs text-midnight-500">{{ $job->last_run_at->diffForHumans() }}</span>
                            </div>
                            @else
                            <span class="text-midnight-500 text-sm">Never</span>
                            @endif
                        </td>
                        <td>
                            @if($job->consecutive_failures > 0)
                            <span class="badge-danger">{{ $job->consecutive_failures }}</span>
                            @else
                            <span class="text-midnight-500">0</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($jobs->hasPages())
        <div class="px-6 py-4 border-t border-midnight-800">
            {{ $jobs->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
