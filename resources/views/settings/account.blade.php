<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-midnight-50">Account Settings</h1>
        <p class="text-sm text-midnight-400 mt-1">Manage your account preferences</p>
    </x-slot>

    <div class="max-w-2xl">
        <form action="{{ route('settings.account.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card p-6 space-y-6">
                <div>
                    <label for="name" class="label">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                           class="input @error('name') input-error @enderror" required>
                    @error('name')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="label">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                           class="input @error('email') input-error @enderror" required>
                    @error('email')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="timezone" class="label">Timezone</label>
                    <input type="text" name="timezone" id="timezone" value="{{ old('timezone', $user->timezone) }}" 
                           class="input @error('timezone') input-error @enderror" placeholder="UTC">
                    <p class="mt-1.5 text-xs text-midnight-500">This timezone will be used as the default for new jobs</p>
                    @error('timezone')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notification_email" class="label">Notification Email</label>
                    <input type="email" name="notification_email" id="notification_email" 
                           value="{{ old('notification_email', $user->notification_email) }}" 
                           class="input @error('notification_email') input-error @enderror">
                    <p class="mt-1.5 text-xs text-midnight-500">Failure alerts will be sent to this email</p>
                    @error('notification_email')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 border-t border-midnight-800">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Changes
                    </button>
                </div>
            </div>
        </form>

        <!-- Plan Info -->
        <div class="card p-6 mt-6">
            <h3 class="text-lg font-semibold text-midnight-50 mb-4">Current Plan</h3>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-midnight-100 font-medium">{{ $user->plan?->name ?? 'Free' }} Plan</p>
                    <p class="text-sm text-midnight-400">
                        {{ $user->plan?->max_jobs ?? 5 }} jobs • 
                        {{ $user->plan?->min_interval_minutes ?? 15 }} min interval • 
                        {{ $user->plan?->log_retention_days ?? 30 }} days retention
                    </p>
                </div>
                <a href="{{ route('pricing') }}" class="btn-secondary text-sm">
                    Upgrade Plan
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
