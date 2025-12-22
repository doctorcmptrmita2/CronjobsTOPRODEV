<x-app-layout>
    <x-slot name="title">{{ $check->name }} - Uptime</x-slot>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('uptime.index') }}" class="p-2 hover:bg-midnight-800 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-midnight-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-bold text-midnight-50">{{ $check->name }}</h1>
                        @if(!$check->is_active)
                        <span class="px-2 py-1 bg-gray-500/10 text-gray-400 text-xs font-medium rounded">Paused</span>
                        @elseif($check->is_up)
                        <span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-medium rounded flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                            Up
                        </span>
                        @else
                        <span class="px-2 py-1 bg-red-500/10 text-red-400 text-xs font-medium rounded flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full animate-pulse"></span>
                            Down
                        </span>
                        @endif
                    </div>
                    <p class="text-sm text-midnight-400 mt-1 font-mono">{{ $check->url }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <form action="{{ route('uptime.run-now', $check) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Run Now
                    </button>
                </form>
                <a href="{{ route('uptime.edit', $check) }}" class="btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @foreach(['1h' => 'Last Hour', '24h' => 'Last 24h', '7d' => 'Last 7 Days', '30d' => 'Last 30 Days'] as $key => $label)
        <div class="card p-4">
            <p class="text-xs text-midnight-500 mb-2">{{ $label }}</p>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-2xl font-bold text-{{ $stats[$key]['uptime'] >= 99.9 ? 'emerald' : ($stats[$key]['uptime'] >= 99 ? 'green' : ($stats[$key]['uptime'] >= 95 ? 'amber' : 'red')) }}-400">
                        {{ number_format($stats[$key]['uptime'], 2) }}%
                    </p>
                    <p class="text-xs text-midnight-500">Uptime</p>
                </div>
                <div class="text-right">
                    @if($stats[$key]['avg_response'])
                    <p class="text-lg font-semibold text-midnight-300">{{ $stats[$key]['avg_response'] }}ms</p>
                    <p class="text-xs text-midnight-500">Avg Response</p>
                    @else
                    <p class="text-lg text-midnight-500">—</p>
                    @endif
                </div>
            </div>
            @if($stats[$key]['incidents'] > 0)
            <p class="mt-2 text-xs text-red-400">{{ $stats[$key]['incidents'] }} {{ $stats[$key]['incidents'] === 1 ? 'incident' : 'incidents' }}</p>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Response Time Chart -->
    <div class="card p-6 mb-8">
        <h3 class="text-lg font-semibold text-midnight-50 mb-6">Response Time</h3>
        
        @if($recentRuns->isEmpty())
        <div class="text-center py-8">
            <p class="text-midnight-500">No data available yet</p>
        </div>
        @else
        <div class="h-40 flex items-end gap-1">
            @php
                $maxResponse = $recentRuns->max('response_time_ms') ?: 1000;
            @endphp
            @foreach($recentRuns as $run)
            @php
                $height = $run->response_time_ms ? min(100, ($run->response_time_ms / $maxResponse) * 100) : 5;
                $color = !$run->is_up ? 'red' : ($run->response_time_ms < 200 ? 'emerald' : ($run->response_time_ms < 500 ? 'green' : ($run->response_time_ms < 1000 ? 'amber' : 'red')));
            @endphp
            <div class="flex-1 flex flex-col items-center justify-end group cursor-pointer">
                <div class="relative">
                    <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 hidden group-hover:block z-10">
                        <div class="bg-midnight-800 px-3 py-2 rounded-lg shadow-lg whitespace-nowrap text-xs border border-midnight-700">
                            <p class="text-midnight-100 font-medium">{{ $run->checked_at->format('M d, H:i:s') }}</p>
                            <p class="text-{{ $run->is_up ? 'emerald' : 'red' }}-400">
                                {{ $run->is_up ? 'Up' : 'Down' }}
                                @if($run->response_time_ms) - {{ $run->response_time_ms }}ms @endif
                            </p>
                            @if($run->error_message)
                            <p class="text-red-400 max-w-xs truncate">{{ $run->error_message }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-full rounded-t bg-{{ $color }}-500/80 transition-all hover:bg-{{ $color }}-500" 
                     style="height: {{ $height }}%"></div>
            </div>
            @endforeach
        </div>
        <div class="flex justify-between mt-2 text-xs text-midnight-500">
            <span>{{ $recentRuns->first()?->checked_at?->diffForHumans() ?? '' }}</span>
            <span>Now</span>
        </div>
        @endif
    </div>

    <!-- Uptime Bar -->
    <div class="card p-6 mb-8">
        <h3 class="text-lg font-semibold text-midnight-50 mb-6">Uptime (Last 100 checks)</h3>
        
        @if($recentRuns->isEmpty())
        <div class="text-center py-8">
            <p class="text-midnight-500">No data available yet</p>
        </div>
        @else
        <div class="flex gap-0.5">
            @foreach($recentRuns as $run)
            <div class="flex-1 h-10 rounded-sm {{ $run->is_up ? 'bg-emerald-500' : 'bg-red-500' }} cursor-pointer group relative">
                <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 hidden group-hover:block z-10">
                    <div class="bg-midnight-800 px-3 py-2 rounded-lg shadow-lg whitespace-nowrap text-xs border border-midnight-700">
                        <p class="text-midnight-100">{{ $run->checked_at->format('M d, H:i') }}</p>
                        <p class="text-{{ $run->is_up ? 'emerald' : 'red' }}-400">{{ $run->is_up ? 'Up' : 'Down' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @for($i = $recentRuns->count(); $i < 100; $i++)
            <div class="flex-1 h-10 rounded-sm bg-midnight-700"></div>
            @endfor
        </div>
        <div class="flex justify-between mt-2 text-xs text-midnight-500">
            <span>Oldest</span>
            <span>Latest</span>
        </div>
        @endif
    </div>

    <!-- Incidents -->
    <div class="card mb-8">
        <div class="px-6 py-4 border-b border-midnight-800">
            <h3 class="text-lg font-semibold text-midnight-50">Recent Incidents (30 days)</h3>
        </div>
        
        @if(empty($incidents))
        <div class="px-6 py-12 text-center">
            <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-emerald-400 font-medium">No incidents in the last 30 days</p>
            <p class="text-midnight-500 text-sm mt-1">Your endpoint has been running smoothly!</p>
        </div>
        @else
        <div class="divide-y divide-midnight-800">
            @foreach($incidents as $incident)
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-4">
                        <div class="w-3 h-3 rounded-full mt-1.5 {{ $incident['ended_at'] ? 'bg-amber-500' : 'bg-red-500 animate-pulse' }}"></div>
                        <div>
                            <p class="font-medium text-midnight-100">
                                {{ $incident['started_at']->format('M d, Y H:i:s') }}
                            </p>
                            <p class="text-sm text-midnight-500 mt-1">
                                Duration: <span class="{{ $incident['ended_at'] ? 'text-midnight-300' : 'text-red-400' }}">{{ $incident['duration'] }}</span>
                                • {{ $incident['checks_failed'] }} failed {{ $incident['checks_failed'] === 1 ? 'check' : 'checks' }}
                            </p>
                            @if($incident['error'])
                            <p class="text-sm text-red-400 mt-2 font-mono bg-red-500/10 px-3 py-2 rounded">{{ $incident['error'] }}</p>
                            @endif
                        </div>
                    </div>
                    @if(!$incident['ended_at'])
                    <span class="px-2 py-1 bg-red-500/10 text-red-400 text-xs font-medium rounded">Ongoing</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Check Details -->
    <div class="card">
        <div class="px-6 py-4 border-b border-midnight-800">
            <h3 class="text-lg font-semibold text-midnight-50">Check Configuration</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <p class="text-xs text-midnight-500 mb-1">Method</p>
                    <p class="font-mono text-midnight-200">{{ $check->http_method }}</p>
                </div>
                <div>
                    <p class="text-xs text-midnight-500 mb-1">Interval</p>
                    <p class="text-midnight-200">{{ $check->interval_text }}</p>
                </div>
                <div>
                    <p class="text-xs text-midnight-500 mb-1">Timeout</p>
                    <p class="text-midnight-200">{{ $check->timeout_seconds }}s</p>
                </div>
                <div>
                    <p class="text-xs text-midnight-500 mb-1">Expected Status</p>
                    <p class="text-midnight-200">{{ $check->expected_status_from }}-{{ $check->expected_status_to }}</p>
                </div>
                @if($check->keyword)
                <div class="col-span-2">
                    <p class="text-xs text-midnight-500 mb-1">Keyword</p>
                    <p class="text-midnight-200">
                        {{ $check->keyword_should_exist ? 'Must contain' : 'Must not contain' }}: 
                        <span class="font-mono bg-midnight-800 px-2 py-0.5 rounded">{{ $check->keyword }}</span>
                    </p>
                </div>
                @endif
                <div>
                    <p class="text-xs text-midnight-500 mb-1">Alert Threshold</p>
                    <p class="text-midnight-200">{{ $check->alert_threshold }} failures</p>
                </div>
                <div>
                    <p class="text-xs text-midnight-500 mb-1">Email Alerts</p>
                    <p class="text-{{ $check->alert_email_enabled ? 'emerald' : 'red' }}-400">
                        {{ $check->alert_email_enabled ? 'Enabled' : 'Disabled' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






