<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-midnight-50">Users</h1>
        <p class="text-sm text-midnight-400 mt-1">Manage all registered users</p>
    </x-slot>

    <div class="card">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Jobs</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="text-midnight-500 font-mono text-sm">{{ $user->id }}</td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-midnight-700 rounded-full flex items-center justify-center text-xs font-medium text-midnight-300">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span class="font-medium text-midnight-100">{{ $user->name }}</span>
                                @if($user->is_admin)
                                <span class="badge-warning text-xs">Admin</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-midnight-400">{{ $user->email }}</td>
                        <td>
                            <span class="badge-neutral">{{ $user->plan?->name ?? 'Free' }}</span>
                        </td>
                        <td class="text-midnight-400">{{ $user->jobs_count }}</td>
                        <td class="text-midnight-500 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-midnight-800">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
