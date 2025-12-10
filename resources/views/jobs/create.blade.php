<x-app-layout>
    <x-slot name="title">Create Job</x-slot>
    
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('jobs.index') }}" class="p-2 text-midnight-400 hover:text-midnight-100 hover:bg-midnight-800 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-midnight-50">Create Cron Job</h1>
                <p class="text-sm text-midnight-400 mt-1">Create a new scheduled task</p>
            </div>
        </div>
    </x-slot>

    <form action="{{ route('jobs.store') }}" method="POST">
        @include('jobs._form', ['job' => new \App\Models\Job()])
    </form>
</x-app-layout>
