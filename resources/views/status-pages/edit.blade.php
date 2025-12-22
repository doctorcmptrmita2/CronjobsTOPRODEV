<x-app-layout>
    <x-slot name="title">Edit Status Page</x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('status-pages.index') }}" class="p-2 text-midnight-400 hover:text-midnight-100 hover:bg-midnight-800 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-midnight-50">Edit Status Page</h1>
                <p class="text-sm text-midnight-400 mt-1">{{ $statusPage->name }}</p>
            </div>
        </div>
    </x-slot>

    <form action="{{ route('status-pages.update', $statusPage) }}" method="POST" class="max-w-2xl">
        @csrf
        @method('PUT')
        @include('status-pages._form', ['statusPage' => $statusPage, 'selectedJobs' => $selectedJobs ?? []])
    </form>
</x-app-layout>









