<x-app-layout>
    <x-slot name="title">Edit {{ $check->name }}</x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('uptime.show', $check) }}" class="p-2 hover:bg-midnight-800 rounded-lg transition-colors">
                <svg class="w-5 h-5 text-midnight-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-midnight-50">Edit {{ $check->name }}</h1>
                <p class="text-sm text-midnight-400 mt-1">Update your uptime check settings</p>
            </div>
        </div>
    </x-slot>

    <form action="{{ route('uptime.update', $check) }}" method="POST">
        @method('PUT')
        @include('uptime._form')
    </form>

    <!-- Delete Section -->
    <div class="mt-8 card p-6 border-red-500/20">
        <h3 class="text-lg font-semibold text-red-400 mb-4">Danger Zone</h3>
        <p class="text-sm text-midnight-400 mb-4">
            Deleting this check will permanently remove all associated run history. This action cannot be undone.
        </p>
        <form action="{{ route('uptime.destroy', $check) }}" method="POST" 
              onsubmit="return confirm('Are you sure you want to delete this check? All history will be lost.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-secondary text-red-400 border-red-500/30 hover:bg-red-500/10">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete Check
            </button>
        </form>
    </div>
</x-app-layout>






