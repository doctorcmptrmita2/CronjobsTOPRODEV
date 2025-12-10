@csrf

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Information -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-midnight-50 mb-6 flex items-center gap-2">
                <div class="w-8 h-8 bg-accent-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                Basic Information
            </h3>
            
            <div class="space-y-5">
                <div>
                    <label for="name" class="label">Job Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $job->name ?? '') }}" 
                           class="input @error('name') input-error @enderror" 
                           placeholder="e.g. Database Backup, Health Check, Send Report" required>
                    @error('name')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="url" class="label">URL <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-midnight-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </div>
                        <input type="url" name="url" id="url" value="{{ old('url', $job->url ?? '') }}" 
                               class="input pl-11 font-mono text-sm @error('url') input-error @enderror" 
                               placeholder="https://api.example.com/webhook" required>
                    </div>
                    <p class="mt-1.5 text-xs text-midnight-500">Full URL starting with HTTP or HTTPS</p>
                    @error('url')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="http_method" class="label">HTTP Method</label>
                        <select name="http_method" id="http_method" class="select">
                            @foreach(['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD'] as $method)
                            <option value="{{ $method }}" {{ old('http_method', $job->http_method ?? 'GET') === $method ? 'selected' : '' }}>
                                {{ $method }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="timeout_seconds" class="label">Timeout</label>
                        <div class="relative">
                            <input type="number" name="timeout_seconds" id="timeout_seconds" 
                                   value="{{ old('timeout_seconds', $job->timeout_seconds ?? 30) }}" 
                                   class="input pr-16" min="1" max="120">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-midnight-500 text-sm">seconds</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enable Job Toggle -->
                <div class="flex items-center justify-between p-4 bg-midnight-800/50 rounded-lg border border-midnight-700">
                    <div>
                        <p class="font-medium text-midnight-100">Enable Job</p>
                        <p class="text-sm text-midnight-400">Start running immediately after creation</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" 
                               {{ old('is_active', $job->is_active ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-midnight-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent-500/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-midnight-400 after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-500 peer-checked:after:bg-white"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Schedule -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-midnight-50 mb-6 flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                Schedule
            </h3>
            
            <div class="space-y-6">
                <!-- Quick Interval Buttons -->
                <div>
                    <label class="label mb-3">Execution Interval</label>
                    <div class="grid grid-cols-4 sm:grid-cols-7 gap-2">
                        @foreach([
                            ['value' => 5, 'label' => '5 Min'],
                            ['value' => 15, 'label' => '15 Min'],
                            ['value' => 30, 'label' => '30 Min'],
                            ['value' => 60, 'label' => '1 Hour'],
                            ['value' => 360, 'label' => '6 Hours'],
                            ['value' => 720, 'label' => '12 Hours'],
                            ['value' => 1440, 'label' => '1 Day'],
                        ] as $interval)
                        <button type="button" 
                                onclick="setInterval({{ $interval['value'] }})"
                                data-interval="{{ $interval['value'] }}"
                                class="interval-btn px-3 py-2.5 text-sm font-medium rounded-lg border transition-all
                                       {{ old('interval_minutes', $job->interval_minutes ?? 15) == $interval['value'] 
                                          ? 'bg-accent-500 text-midnight-950 border-accent-500' 
                                          : 'bg-midnight-800 text-midnight-300 border-midnight-700 hover:border-midnight-600 hover:bg-midnight-750' }}">
                            {{ $interval['label'] }}
                        </button>
                        @endforeach
                    </div>
                    <input type="hidden" name="schedule_type" id="schedule_type" value="{{ old('schedule_type', $job->schedule_type ?? 'interval') }}">
                    <input type="hidden" name="interval_minutes" id="interval_minutes" value="{{ old('interval_minutes', $job->interval_minutes ?? 15) }}">
                </div>

                <!-- Custom Schedule Options -->
                <div class="border-t border-midnight-800 pt-6">
                    <div class="flex items-center gap-2 mb-4">
                        <button type="button" onclick="toggleCustomSchedule()" id="custom-schedule-toggle"
                                class="text-sm text-accent-500 hover:text-accent-400 transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4 transition-transform" id="custom-schedule-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            Advanced Scheduling Options
                        </button>
                    </div>
                    
                    <div id="custom-schedule-panel" class="hidden space-y-4">
                        <!-- Schedule Type Tabs -->
                        <div class="flex gap-2 p-1 bg-midnight-800 rounded-lg">
                            <button type="button" onclick="setScheduleType('daily')" 
                                    class="schedule-tab flex-1 px-4 py-2 text-sm font-medium rounded-md transition-all
                                           {{ old('schedule_type', $job->schedule_type ?? '') === 'daily' ? 'bg-midnight-700 text-midnight-50' : 'text-midnight-400 hover:text-midnight-200' }}">
                                Daily
                            </button>
                            <button type="button" onclick="setScheduleType('weekly')"
                                    class="schedule-tab flex-1 px-4 py-2 text-sm font-medium rounded-md transition-all
                                           {{ old('schedule_type', $job->schedule_type ?? '') === 'weekly' ? 'bg-midnight-700 text-midnight-50' : 'text-midnight-400 hover:text-midnight-200' }}">
                                Weekly
                            </button>
                            <button type="button" onclick="setScheduleType('cron')"
                                    class="schedule-tab flex-1 px-4 py-2 text-sm font-medium rounded-md transition-all
                                           {{ old('schedule_type', $job->schedule_type ?? '') === 'cron' ? 'bg-midnight-700 text-midnight-50' : 'text-midnight-400 hover:text-midnight-200' }}">
                                Cron
                            </button>
                        </div>

                        <!-- Daily Options -->
                        <div id="daily-options" class="hidden">
                            <label for="daily_time" class="label">Run at time</label>
                            <input type="time" name="daily_time" id="daily_time" 
                                   value="{{ old('daily_time', $job->daily_time ?? '00:00') }}" 
                                   class="input">
                        </div>

                        <!-- Weekly Options -->
                        <div id="weekly-options" class="hidden space-y-4">
                            <div>
                                <label class="label mb-3">Day of Week</label>
                                <div class="grid grid-cols-7 gap-2">
                                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $index => $day)
                                    <button type="button" onclick="setWeekday({{ $index }})" data-day="{{ $index }}"
                                            class="weekday-btn px-2 py-2 text-sm font-medium rounded-lg border transition-all
                                                   {{ old('weekly_day_of_week', $job->weekly_day_of_week ?? 1) == $index 
                                                      ? 'bg-accent-500 text-midnight-950 border-accent-500' 
                                                      : 'bg-midnight-800 text-midnight-300 border-midnight-700 hover:border-midnight-600' }}">
                                        {{ $day }}
                                    </button>
                                    @endforeach
                                </div>
                                <input type="hidden" name="weekly_day_of_week" id="weekly_day_of_week" value="{{ old('weekly_day_of_week', $job->weekly_day_of_week ?? 1) }}">
                            </div>
                            <div>
                                <label for="weekly_time" class="label">Run at time</label>
                                <input type="time" name="weekly_time" id="weekly_time" 
                                       value="{{ old('daily_time', $job->daily_time ?? '00:00') }}" 
                                       class="input">
                            </div>
                        </div>

                        <!-- Cron Options -->
                        <div id="cron-options" class="hidden space-y-4">
                            <div>
                                <label for="cron_expression" class="label">Cron Expression</label>
                                <input type="text" name="cron_expression" id="cron_expression" 
                                       value="{{ old('cron_expression', $job->cron_expression ?? '*/15 * * * *') }}" 
                                       class="input font-mono" placeholder="*/15 * * * *"
                                       oninput="updateCronPreview()">
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <button type="button" onclick="setCron('*/5 * * * *')" class="text-xs px-2 py-1 bg-midnight-800 text-midnight-400 rounded hover:bg-midnight-700">Every 5 min</button>
                                    <button type="button" onclick="setCron('0 * * * *')" class="text-xs px-2 py-1 bg-midnight-800 text-midnight-400 rounded hover:bg-midnight-700">Every hour</button>
                                    <button type="button" onclick="setCron('0 0 * * *')" class="text-xs px-2 py-1 bg-midnight-800 text-midnight-400 rounded hover:bg-midnight-700">Every day at midnight</button>
                                    <button type="button" onclick="setCron('0 9 * * 1-5')" class="text-xs px-2 py-1 bg-midnight-800 text-midnight-400 rounded hover:bg-midnight-700">Weekdays 9 AM</button>
                                </div>
                            </div>
                            <div id="cron-preview" class="p-3 bg-midnight-950 rounded-lg border border-midnight-800">
                                <p class="text-xs text-midnight-500 mb-1">Cron format: minute hour day month weekday</p>
                                <p class="text-sm text-midnight-300 font-mono" id="cron-description">Every 15 minutes</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timezone -->
                <div>
                    <label for="timezone" class="label">Timezone</label>
                    <select name="timezone" id="timezone" class="select">
                        @foreach(['UTC', 'America/New_York', 'America/Chicago', 'America/Denver', 'America/Los_Angeles', 'Europe/London', 'Europe/Paris', 'Europe/Berlin', 'Europe/Istanbul', 'Asia/Tokyo', 'Asia/Shanghai', 'Asia/Dubai', 'Australia/Sydney'] as $tz)
                        <option value="{{ $tz }}" {{ old('timezone', $job->timezone ?? auth()->user()->timezone ?? 'UTC') === $tz ? 'selected' : '' }}>
                            {{ $tz }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Request Configuration (Collapsible) -->
        <div class="card overflow-hidden">
            <button type="button" onclick="toggleSection('request')" class="w-full p-6 flex items-center justify-between hover:bg-midnight-800/30 transition-colors">
                <h3 class="text-lg font-semibold text-midnight-50 flex items-center gap-2">
                    <div class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    Request Configuration
                </h3>
                <svg class="w-5 h-5 text-midnight-400 transition-transform" id="request-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="request-section" class="hidden px-6 pb-6 space-y-6">
                <!-- Headers -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="label mb-0">HTTP Headers</label>
                        <button type="button" onclick="addHeader()" class="text-sm text-accent-500 hover:text-accent-400 transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Header
                        </button>
                    </div>
                    <div id="headers-container" class="space-y-2">
                        @php
                            $headers = old('headers', isset($job) && $job->headers_json ? json_decode($job->headers_json, true) : []);
                            if (empty($headers)) $headers = [['key' => '', 'value' => '']];
                        @endphp
                        @foreach($headers as $index => $header)
                        <div class="flex gap-2 header-row">
                            <input type="text" name="headers[{{ $index }}][key]" value="{{ $header['key'] ?? '' }}" 
                                   class="input flex-1 font-mono text-sm" placeholder="Header name">
                            <input type="text" name="headers[{{ $index }}][value]" value="{{ $header['value'] ?? '' }}" 
                                   class="input flex-1 font-mono text-sm" placeholder="Header value">
                            <button type="button" onclick="removeHeader(this)" class="p-2.5 text-midnight-500 hover:text-red-400 hover:bg-midnight-800 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-2 flex flex-wrap gap-2">
                        <button type="button" onclick="addPresetHeader('Content-Type', 'application/json')" class="text-xs px-2 py-1 bg-midnight-800 text-midnight-400 rounded hover:bg-midnight-700">+ Content-Type: JSON</button>
                        <button type="button" onclick="addPresetHeader('Authorization', 'Bearer ')" class="text-xs px-2 py-1 bg-midnight-800 text-midnight-400 rounded hover:bg-midnight-700">+ Authorization</button>
                        <button type="button" onclick="addPresetHeader('Accept', 'application/json')" class="text-xs px-2 py-1 bg-midnight-800 text-midnight-400 rounded hover:bg-midnight-700">+ Accept: JSON</button>
                    </div>
                </div>

                <!-- Request Body -->
                <div>
                    <label for="body" class="label">Request Body</label>
                    <textarea name="body" id="body" rows="5" 
                              class="input font-mono text-sm" 
                              placeholder='{"key": "value"}'>{{ old('body', $job->body ?? '') }}</textarea>
                    <p class="mt-1.5 text-xs text-midnight-500">JSON or plain text body for POST/PUT/PATCH requests</p>
                </div>
            </div>
        </div>

        <!-- Advanced Settings (Collapsible) -->
        <div class="card overflow-hidden">
            <button type="button" onclick="toggleSection('advanced')" class="w-full p-6 flex items-center justify-between hover:bg-midnight-800/30 transition-colors">
                <h3 class="text-lg font-semibold text-midnight-50 flex items-center gap-2">
                    <div class="w-8 h-8 bg-emerald-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    Advanced Settings
                </h3>
                <svg class="w-5 h-5 text-midnight-400 transition-transform" id="advanced-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="advanced-section" class="hidden px-6 pb-6 space-y-6">
                <!-- Response Validation -->
                <div>
                    <label class="label mb-3">Response Validation</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="expected_status_from" class="text-xs text-midnight-500 mb-1 block">Expected Status (from)</label>
                            <input type="number" name="expected_status_from" id="expected_status_from" 
                                   value="{{ old('expected_status_from', $job->expected_status_from ?? 200) }}" 
                                   class="input" min="100" max="599">
                        </div>
                        <div>
                            <label for="expected_status_to" class="text-xs text-midnight-500 mb-1 block">Expected Status (to)</label>
                            <input type="number" name="expected_status_to" id="expected_status_to" 
                                   value="{{ old('expected_status_to', $job->expected_status_to ?? 299) }}" 
                                   class="input" min="100" max="599">
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-midnight-500">Job will be marked as failed if response status is outside this range</p>
                </div>

                <!-- Retry Configuration -->
                <div>
                    <label class="label mb-3">Automatic Retries</label>
                    <div class="flex items-center gap-4">
                        <div class="flex-1">
                            <input type="number" name="max_retries" id="max_retries" 
                                   value="{{ old('max_retries', $job->max_retries ?? 3) }}" 
                                   class="input" min="0" max="5">
                        </div>
                        <span class="text-sm text-midnight-400">retries on failure</span>
                    </div>
                    <p class="mt-2 text-xs text-midnight-500">Failed requests will be automatically retried up to this many times</p>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="label">Description (optional)</label>
                    <textarea name="description" id="description" rows="2" 
                              class="input" placeholder="What does this job do?">{{ old('description', $job->description ?? '') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Next Execution Preview -->
        <div class="card p-6">
            <h3 class="text-sm font-semibold text-midnight-400 uppercase tracking-wider mb-4">Next Executions</h3>
            <div id="next-runs" class="space-y-2">
                <div class="flex items-center gap-3 text-sm">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                    <span class="text-midnight-300" id="next-run-1">Calculating...</span>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <div class="w-2 h-2 bg-midnight-600 rounded-full"></div>
                    <span class="text-midnight-500" id="next-run-2">—</span>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <div class="w-2 h-2 bg-midnight-600 rounded-full"></div>
                    <span class="text-midnight-500" id="next-run-3">—</span>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="card p-6">
            <h3 class="text-sm font-semibold text-midnight-400 uppercase tracking-wider mb-4">Notifications</h3>
            <div class="space-y-4">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="hidden" name="alert_email_enabled" value="0">
                    <input type="checkbox" name="alert_email_enabled" value="1" 
                           {{ old('alert_email_enabled', $job->alert_email_enabled ?? true) ? 'checked' : '' }}
                           class="mt-0.5 w-4 h-4 rounded border-midnight-700 bg-midnight-800 text-accent-500 focus:ring-accent-500 focus:ring-offset-midnight-900">
                    <div>
                        <span class="text-sm text-midnight-200">Email on failure</span>
                        <p class="text-xs text-midnight-500 mt-0.5">Get notified when job fails</p>
                    </div>
                </label>
                
                <div>
                    <label for="failure_alert_threshold" class="text-xs text-midnight-500 mb-1 block">Alert after consecutive failures</label>
                    <select name="failure_alert_threshold" id="failure_alert_threshold" class="select text-sm">
                        @foreach([1, 2, 3, 5, 10] as $threshold)
                        <option value="{{ $threshold }}" {{ old('failure_alert_threshold', $job->failure_alert_threshold ?? 3) == $threshold ? 'selected' : '' }}>
                            {{ $threshold }} {{ $threshold === 1 ? 'failure' : 'failures' }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="space-y-3">
            <button type="submit" class="btn-primary w-full justify-center py-3">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ isset($job) && $job->exists ? 'Update Job' : 'Create Job' }}
            </button>
            <a href="{{ route('jobs.index') }}" class="btn-secondary w-full justify-center py-3">
                Cancel
            </a>
        </div>
    </div>
</div>

<script>
let headerIndex = {{ count($headers ?? []) }};

// Interval Selection
function setInterval(minutes) {
    document.getElementById('interval_minutes').value = minutes;
    document.getElementById('schedule_type').value = 'interval';
    
    document.querySelectorAll('.interval-btn').forEach(btn => {
        const isActive = parseInt(btn.dataset.interval) === minutes;
        btn.classList.toggle('bg-accent-500', isActive);
        btn.classList.toggle('text-midnight-950', isActive);
        btn.classList.toggle('border-accent-500', isActive);
        btn.classList.toggle('bg-midnight-800', !isActive);
        btn.classList.toggle('text-midnight-300', !isActive);
        btn.classList.toggle('border-midnight-700', !isActive);
    });
    
    updateNextRuns();
}

// Custom Schedule
function toggleCustomSchedule() {
    const panel = document.getElementById('custom-schedule-panel');
    const arrow = document.getElementById('custom-schedule-arrow');
    panel.classList.toggle('hidden');
    arrow.classList.toggle('rotate-180');
}

function setScheduleType(type) {
    document.getElementById('schedule_type').value = type;
    
    // Update tabs
    document.querySelectorAll('.schedule-tab').forEach(tab => {
        tab.classList.remove('bg-midnight-700', 'text-midnight-50');
        tab.classList.add('text-midnight-400');
    });
    event.target.classList.add('bg-midnight-700', 'text-midnight-50');
    event.target.classList.remove('text-midnight-400');
    
    // Show/hide options
    document.getElementById('daily-options').classList.toggle('hidden', type !== 'daily');
    document.getElementById('weekly-options').classList.toggle('hidden', type !== 'weekly');
    document.getElementById('cron-options').classList.toggle('hidden', type !== 'cron');
    
    // Deselect interval buttons
    document.querySelectorAll('.interval-btn').forEach(btn => {
        btn.classList.remove('bg-accent-500', 'text-midnight-950', 'border-accent-500');
        btn.classList.add('bg-midnight-800', 'text-midnight-300', 'border-midnight-700');
    });
    
    updateNextRuns();
}

function setWeekday(day) {
    document.getElementById('weekly_day_of_week').value = day;
    
    document.querySelectorAll('.weekday-btn').forEach(btn => {
        const isActive = parseInt(btn.dataset.day) === day;
        btn.classList.toggle('bg-accent-500', isActive);
        btn.classList.toggle('text-midnight-950', isActive);
        btn.classList.toggle('border-accent-500', isActive);
        btn.classList.toggle('bg-midnight-800', !isActive);
        btn.classList.toggle('text-midnight-300', !isActive);
        btn.classList.toggle('border-midnight-700', !isActive);
    });
    
    updateNextRuns();
}

function setCron(expression) {
    document.getElementById('cron_expression').value = expression;
    updateCronPreview();
    updateNextRuns();
}

function updateCronPreview() {
    const expr = document.getElementById('cron_expression').value;
    const desc = document.getElementById('cron-description');
    
    // Simple cron descriptions
    const descriptions = {
        '*/5 * * * *': 'Every 5 minutes',
        '*/15 * * * *': 'Every 15 minutes',
        '*/30 * * * *': 'Every 30 minutes',
        '0 * * * *': 'Every hour',
        '0 */2 * * *': 'Every 2 hours',
        '0 0 * * *': 'Every day at midnight',
        '0 9 * * *': 'Every day at 9:00 AM',
        '0 9 * * 1-5': 'Weekdays at 9:00 AM',
        '0 0 * * 0': 'Every Sunday at midnight',
        '0 0 1 * *': 'First day of every month',
    };
    
    desc.textContent = descriptions[expr] || 'Custom schedule';
}

// Headers
function addHeader() {
    const container = document.getElementById('headers-container');
    const row = document.createElement('div');
    row.className = 'flex gap-2 header-row';
    row.innerHTML = `
        <input type="text" name="headers[${headerIndex}][key]" class="input flex-1 font-mono text-sm" placeholder="Header name">
        <input type="text" name="headers[${headerIndex}][value]" class="input flex-1 font-mono text-sm" placeholder="Header value">
        <button type="button" onclick="removeHeader(this)" class="p-2.5 text-midnight-500 hover:text-red-400 hover:bg-midnight-800 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    `;
    container.appendChild(row);
    headerIndex++;
}

function removeHeader(btn) {
    const rows = document.querySelectorAll('.header-row');
    if (rows.length > 1) {
        btn.closest('.header-row').remove();
    }
}

function addPresetHeader(key, value) {
    const container = document.getElementById('headers-container');
    const existingRows = container.querySelectorAll('.header-row');
    
    // Check if there's an empty row to use
    for (const row of existingRows) {
        const keyInput = row.querySelector('input[placeholder="Header name"]');
        if (keyInput && keyInput.value === '') {
            keyInput.value = key;
            row.querySelector('input[placeholder="Header value"]').value = value;
            return;
        }
    }
    
    // Otherwise add new row
    addHeader();
    const newRow = container.lastElementChild;
    newRow.querySelector('input[placeholder="Header name"]').value = key;
    newRow.querySelector('input[placeholder="Header value"]').value = value;
}

// Collapsible Sections
function toggleSection(section) {
    const sectionEl = document.getElementById(section + '-section');
    const arrow = document.getElementById(section + '-arrow');
    sectionEl.classList.toggle('hidden');
    arrow.classList.toggle('rotate-180');
}

// Next Runs Preview
function updateNextRuns() {
    const type = document.getElementById('schedule_type').value;
    const interval = parseInt(document.getElementById('interval_minutes').value) || 15;
    
    const now = new Date();
    const runs = [];
    
    if (type === 'interval') {
        for (let i = 1; i <= 3; i++) {
            const next = new Date(now.getTime() + (interval * i * 60 * 1000));
            runs.push(formatDate(next));
        }
    } else {
        runs.push('Based on schedule', '—', '—');
    }
    
    document.getElementById('next-run-1').textContent = runs[0];
    document.getElementById('next-run-2').textContent = runs[1];
    document.getElementById('next-run-3').textContent = runs[2];
}

function formatDate(date) {
    const options = { 
        weekday: 'short', 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit', 
        minute: '2-digit'
    };
    return date.toLocaleDateString('en-US', options);
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateNextRuns();
    updateCronPreview();
    
    // Show custom schedule panel if not interval
    const type = document.getElementById('schedule_type').value;
    if (type !== 'interval') {
        document.getElementById('custom-schedule-panel').classList.remove('hidden');
        document.getElementById('custom-schedule-arrow').classList.add('rotate-180');
        
        document.getElementById('daily-options').classList.toggle('hidden', type !== 'daily');
        document.getElementById('weekly-options').classList.toggle('hidden', type !== 'weekly');
        document.getElementById('cron-options').classList.toggle('hidden', type !== 'cron');
    }
});
</script>
