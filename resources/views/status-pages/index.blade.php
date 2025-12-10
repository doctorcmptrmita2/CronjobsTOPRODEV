<x-app-layout>
    <x-slot name="title">Status Pages</x-slot>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-midnight-50">Status Pages</h1>
                <p class="text-sm text-midnight-400 mt-1">Create public status pages for your services</p>
            </div>
            <a href="{{ route('status-pages.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Status Page
            </a>
        </div>
    </x-slot>

    @if($statusPages->isEmpty())
    <div class="card p-12 text-center">
        <div class="w-20 h-20 bg-midnight-800 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-midnight-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-midnight-100 mb-2">No status pages yet</h3>
        <p class="text-midnight-400 mb-6 max-w-md mx-auto">
            Create a public status page to let your users know when your services are operational.
        </p>
        <a href="{{ route('status-pages.create') }}" class="btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Your First Status Page
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($statusPages as $page)
        <div class="card p-6 hover:border-midnight-700 transition-colors">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-midnight-100">{{ $page->name }}</h3>
                    @if($page->description)
                    <p class="text-sm text-midnight-500 mt-1">{{ Str::limit($page->description, 60) }}</p>
                    @endif
                </div>
                @if($page->is_public)
                <span class="badge-success">Public</span>
                @else
                <span class="badge-neutral">Draft</span>
                @endif
            </div>

            <div class="flex items-center gap-2 mb-4">
                <div class="flex-1 px-3 py-2 bg-midnight-950 rounded-lg">
                    <p class="text-xs text-midnight-500 mb-1">Public URL</p>
                    <p class="text-sm text-midnight-300 font-mono truncate">{{ url('/status/' . $page->slug) }}</p>
                </div>
                <button onclick="navigator.clipboard.writeText('{{ url('/status/' . $page->slug) }}')" 
                        class="p-2 text-midnight-500 hover:text-midnight-300 hover:bg-midnight-800 rounded-lg transition-colors"
                        title="Copy URL">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </button>
            </div>

            <div class="flex items-center gap-2 pt-4 border-t border-midnight-800">
                @if($page->is_public)
                <a href="{{ route('status.public', $page->slug) }}" target="_blank" class="btn-secondary text-sm flex-1 justify-center">
                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    View
                </a>
                @endif
                <a href="{{ route('status-pages.edit', $page) }}" class="btn-secondary text-sm flex-1 justify-center">
                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <form action="{{ route('status-pages.destroy', $page) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this status page?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-midnight-500 hover:text-red-400 hover:bg-midnight-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</x-app-layout>

