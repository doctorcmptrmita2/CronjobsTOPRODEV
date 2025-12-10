<x-app-layout>
    <x-slot name="title">Notification Settings</x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('settings') }}" class="p-2 text-midnight-400 hover:text-midnight-100 hover:bg-midnight-800 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-midnight-50">Notification Settings</h1>
                <p class="text-sm text-midnight-400 mt-1">Configure how you receive alerts</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <form action="{{ route('settings.notifications.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card p-6 space-y-6">
                <!-- Email Notifications -->
                <div>
                    <h3 class="text-lg font-semibold text-midnight-50 mb-4">Email Notifications</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="notification_email" class="label">Notification Email</label>
                            <input type="email" name="notification_email" id="notification_email" 
                                   value="{{ old('notification_email', $user->notification_email) }}" 
                                   class="input @error('notification_email') input-error @enderror"
                                   placeholder="{{ $user->email }}">
                            <p class="mt-1.5 text-xs text-midnight-500">Leave empty to use your account email ({{ $user->email }})</p>
                            @error('notification_email')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Alert Types -->
                <div class="pt-6 border-t border-midnight-800">
                    <h3 class="text-lg font-semibold text-midnight-50 mb-4">Alert Types</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-midnight-800/50 rounded-lg">
                            <div>
                                <p class="font-medium text-midnight-100">Job Failure Alerts</p>
                                <p class="text-sm text-midnight-400">Get notified when a job fails multiple times</p>
                            </div>
                            <div class="text-emerald-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-midnight-800/50 rounded-lg opacity-50">
                            <div>
                                <p class="font-medium text-midnight-100">Weekly Summary</p>
                                <p class="text-sm text-midnight-400">Receive a weekly report of all job activities</p>
                            </div>
                            <span class="badge-neutral text-xs">Coming Soon</span>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-midnight-800/50 rounded-lg opacity-50">
                            <div>
                                <p class="font-medium text-midnight-100">Slack Notifications</p>
                                <p class="text-sm text-midnight-400">Send alerts to your Slack workspace</p>
                            </div>
                            <span class="badge-neutral text-xs">Coming Soon</span>
                        </div>
                    </div>
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
    </div>
</x-app-layout>

