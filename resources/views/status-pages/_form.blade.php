<div class="space-y-6">
    <!-- Basic Info -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold text-midnight-50 mb-6">Basic Information</h3>
        
        <div class="space-y-5">
            <div>
                <label for="name" class="label">Page Name <span class="text-red-400">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $statusPage->name ?? '') }}" 
                       class="input @error('name') input-error @enderror" 
                       placeholder="My Service Status" required>
                @error('name')
                <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="label">URL Slug <span class="text-red-400">*</span></label>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-midnight-500">{{ url('/status/') }}/</span>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $statusPage->slug ?? '') }}" 
                           class="input flex-1 font-mono @error('slug') input-error @enderror" 
                           placeholder="my-service" required>
                </div>
                @error('slug')
                <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="label">Description</label>
                <textarea name="description" id="description" rows="2" 
                          class="input" placeholder="Brief description of your service">{{ old('description', $statusPage->description ?? '') }}</textarea>
            </div>

            <div class="flex items-center justify-between p-4 bg-midnight-800/50 rounded-lg border border-midnight-700">
                <div>
                    <p class="font-medium text-midnight-100">Make Public</p>
                    <p class="text-sm text-midnight-400">Allow anyone to view this status page</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_public" value="0">
                    <input type="checkbox" name="is_public" value="1" 
                           {{ old('is_public', $statusPage->is_public ?? false) ? 'checked' : '' }}
                           class="sr-only peer">
                    <div class="w-11 h-6 bg-midnight-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent-500/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-midnight-400 after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-500 peer-checked:after:bg-white"></div>
                </label>
            </div>
        </div>
    </div>

    <!-- Select Jobs -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold text-midnight-50 mb-6">Select Jobs to Monitor</h3>
        
        @if($jobs->isEmpty())
        <div class="text-center py-8">
            <p class="text-midnight-500">No active jobs found. Create some jobs first.</p>
        </div>
        @else
        <div class="space-y-2">
            @foreach($jobs as $job)
            <label class="flex items-center gap-3 p-3 bg-midnight-800/30 rounded-lg cursor-pointer hover:bg-midnight-800/50 transition-colors">
                <input type="checkbox" name="jobs[]" value="{{ $job->id }}" 
                       {{ in_array($job->id, old('jobs', $selectedJobs ?? [])) ? 'checked' : '' }}
                       class="w-4 h-4 rounded border-midnight-700 bg-midnight-800 text-accent-500 focus:ring-accent-500 focus:ring-offset-midnight-900">
                <div class="flex-1">
                    <p class="text-sm font-medium text-midnight-200">{{ $job->name }}</p>
                    <p class="text-xs text-midnight-500 font-mono">{{ $job->url }}</p>
                </div>
                @if($job->is_active)
                <span class="badge-success text-xs">Active</span>
                @endif
            </label>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('status-pages.index') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ $statusPage->exists ? 'Update Status Page' : 'Create Status Page' }}
        </button>
    </div>
</div>









