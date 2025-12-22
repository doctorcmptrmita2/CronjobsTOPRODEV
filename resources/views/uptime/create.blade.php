<x-app-layout>
    <x-slot name="title">New Uptime Check</x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('uptime.index') }}" class="p-2 hover:bg-midnight-800 rounded-lg transition-colors">
                <svg class="w-5 h-5 text-midnight-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-midnight-50">New Uptime Check</h1>
                <p class="text-sm text-midnight-400 mt-1">Create a new endpoint monitor</p>
            </div>
        </div>
    </x-slot>

    <form action="{{ route('uptime.store') }}" method="POST">
        @include('uptime._form')
    </form>
</x-app-layout>






