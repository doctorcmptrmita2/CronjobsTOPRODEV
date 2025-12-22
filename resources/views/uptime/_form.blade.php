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
                    <label for="name" class="label">Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $check->name ?? '') }}" 
                           class="input @error('name') input-error @enderror" 
                           placeholder="e.g. Production API, Homepage" required>
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
                        <input type="url" name="url" id="url" value="{{ old('url', $check->url ?? '') }}" 
                               class="input pl-11 font-mono text-sm @error('url') input-error @enderror" 
                               placeholder="https://api.example.com/health" required>
                    </div>
                    <p class="mt-1.5 text-xs text-midnight-500">Full URL to monitor (must be publicly accessible)</p>
                    @error('url')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="http_method" class="label">HTTP Method</label>
                        <select name="http_method" id="http_method" class="select @error('http_method') input-error @enderror">
                            @foreach(['GET', 'HEAD', 'POST'] as $method)
                            <option value="{{ $method }}" {{ old('http_method', $check->http_method ?? 'GET') === $method ? 'selected' : '' }}>
                                {{ $method }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="interval_seconds" class="label">Check Interval</label>
                        <select name="interval_seconds" id="interval_seconds" class="select @error('interval_seconds') input-error @enderror">
                            @foreach(\App\Models\Check::INTERVALS as $seconds => $label)
                            <option value="{{ $seconds }}" {{ old('interval_seconds', $check->interval_seconds ?? 60) == $seconds ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="timeout_seconds" class="label">Timeout</label>
                        <div class="relative">
                            <input type="number" name="timeout_seconds" id="timeout_seconds" 
                                   value="{{ old('timeout_seconds', $check->timeout_seconds ?? 30) }}" 
                                   class="input pr-12 @error('timeout_seconds') input-error @enderror" 
                                   min="5" max="60">
                            <span class="absolute inset-y-0 right-0 pr-4 flex items-center text-midnight-500 text-sm">sec</span>
                        </div>
                    </div>
                    
                    <div>
                        <label for="expected_status_from" class="label">Status From</label>
                        <input type="number" name="expected_status_from" id="expected_status_from" 
                               value="{{ old('expected_status_from', $check->expected_status_from ?? 200) }}" 
                               class="input @error('expected_status_from') input-error @enderror" 
                               min="100" max="599">
                    </div>
                    
                    <div>
                        <label for="expected_status_to" class="label">Status To</label>
                        <input type="number" name="expected_status_to" id="expected_status_to" 
                               value="{{ old('expected_status_to', $check->expected_status_to ?? 299) }}" 
                               class="input @error('expected_status_to') input-error @enderror" 
                               min="100" max="599">
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Options -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-midnight-50 mb-6 flex items-center gap-2">
                <div class="w-8 h-8 bg-accent-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                Advanced Options
            </h3>
            
            <div class="space-y-5">
                <!-- Keyword Check -->
                <div>
                    <label for="keyword" class="label">Keyword Check (optional)</label>
                    <input type="text" name="keyword" id="keyword" value="{{ old('keyword', $check->keyword ?? '') }}" 
                           class="input @error('keyword') input-error @enderror" 
                           placeholder="e.g. OK, healthy, success">
                    <p class="mt-1.5 text-xs text-midnight-500">Check if response body contains (or doesn't contain) this text</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="keyword_should_exist" value="0">
                        <input type="checkbox" name="keyword_should_exist" value="1" class="sr-only peer"
                               {{ old('keyword_should_exist', $check->keyword_should_exist ?? true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-midnight-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent-500/50 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-500"></div>
                    </label>
                    <span class="text-sm text-midnight-300">Keyword should exist in response</span>
                </div>

                <!-- HTTP Headers -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="label mb-0">HTTP Headers</label>
                        <button type="button" onclick="addHeader()" class="text-sm text-accent-400 hover:text-accent-300 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Header
                        </button>
                    </div>
                    <div id="headers-container" class="space-y-2">
                        @php
                            $headers = old('headers', []);
                            if (empty($headers) && $check->headers_json) {
                                foreach ($check->headers_json as $key => $value) {
                                    $headers[] = ['key' => $key, 'value' => $value];
                                }
                            }
                            if (empty($headers)) {
                                $headers[] = ['key' => '', 'value' => ''];
                            }
                        @endphp
                        @foreach($headers as $index => $header)
                        <div class="flex items-center gap-2 header-row">
                            <input type="text" name="headers[{{ $index }}][key]" value="{{ $header['key'] ?? '' }}" 
                                   class="input flex-1" placeholder="Header name">
                            <input type="text" name="headers[{{ $index }}][value]" value="{{ $header['value'] ?? '' }}" 
                                   class="input flex-1" placeholder="Header value">
                            <button type="button" onclick="removeHeader(this)" class="p-2 text-midnight-500 hover:text-red-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Request Body -->
                <div>
                    <label for="body" class="label">Request Body (optional)</label>
                    <textarea name="body" id="body" rows="3" 
                              class="input font-mono text-sm @error('body') input-error @enderror" 
                              placeholder='{"key": "value"}'>{{ old('body', $check->body ?? '') }}</textarea>
                    <p class="mt-1.5 text-xs text-midnight-500">JSON or plain text body for POST requests</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Status -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-midnight-50 mb-6">Status</h3>
            
            <div class="space-y-4">
                <label class="flex items-center justify-between p-3 bg-midnight-800/50 rounded-lg cursor-pointer hover:bg-midnight-800 transition-colors">
                    <span class="text-sm text-midnight-200">Monitor Active</span>
                    <div class="relative">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                               {{ old('is_active', $check->is_active ?? true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-midnight-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent-500/50 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                    </div>
                </label>
            </div>
        </div>

        <!-- Notifications -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-midnight-50 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                Notifications
            </h3>
            
            <div class="space-y-4">
                <label class="flex items-center justify-between p-3 bg-midnight-800/50 rounded-lg cursor-pointer hover:bg-midnight-800 transition-colors">
                    <div>
                        <span class="text-sm text-midnight-200 block">Email on failure</span>
                        <span class="text-xs text-midnight-500">Get notified when check fails</span>
                    </div>
                    <div class="relative">
                        <input type="hidden" name="alert_email_enabled" value="0">
                        <input type="checkbox" name="alert_email_enabled" value="1" class="sr-only peer"
                               {{ old('alert_email_enabled', $check->alert_email_enabled ?? true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-midnight-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent-500/50 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-500"></div>
                    </div>
                </label>

                <div>
                    <label for="alert_threshold" class="label">Alert after failures</label>
                    <select name="alert_threshold" id="alert_threshold" class="select">
                        @foreach([1, 2, 3, 5, 10] as $threshold)
                        <option value="{{ $threshold }}" {{ old('alert_threshold', $check->alert_threshold ?? 2) == $threshold ? 'selected' : '' }}>
                            {{ $threshold }} consecutive {{ $threshold === 1 ? 'failure' : 'failures' }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card p-6">
            <button type="submit" class="btn-primary w-full justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ isset($check->id) ? 'Update Check' : 'Create Check' }}
            </button>
            
            <a href="{{ route('uptime.index') }}" class="btn-secondary w-full justify-center mt-3">
                Cancel
            </a>
        </div>
    </div>
</div>

<script>
let headerIndex = {{ count($headers) }};

function addHeader() {
    const container = document.getElementById('headers-container');
    const row = document.createElement('div');
    row.className = 'flex items-center gap-2 header-row';
    row.innerHTML = `
        <input type="text" name="headers[${headerIndex}][key]" class="input flex-1" placeholder="Header name">
        <input type="text" name="headers[${headerIndex}][value]" class="input flex-1" placeholder="Header value">
        <button type="button" onclick="removeHeader(this)" class="p-2 text-midnight-500 hover:text-red-400 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
</script>






