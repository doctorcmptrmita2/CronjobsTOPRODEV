<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-midnight-50">Welcome back</h1>
        <p class="text-sm text-midnight-400 mt-2">Sign in to your account to continue</p>
    </div>

    @if(session('pending_job'))
    <div class="mb-6 p-4 bg-accent-500/10 border border-accent-500/20 rounded-lg">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-accent-500 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-midnight-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-accent-400">Your job is ready to be monitored!</p>
                <p class="text-xs text-midnight-400 mt-1 font-mono truncate">{{ session('pending_job.url') }}</p>
                <p class="text-xs text-midnight-500 mt-0.5">{{ session('pending_job.cron_expression') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Session Status -->
    @if (session('status'))
    <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-lg text-emerald-400 text-sm">
        {{ session('status') }}
    </div>
    @endif

    @if(session('info'))
    <div class="mb-6 p-4 bg-blue-500/10 border border-blue-500/20 rounded-lg text-blue-400 text-sm">
        {{ session('info') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="input @error('email') input-error @enderror">
            @error('email')
            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="label">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="input @error('password') input-error @enderror">
            @error('password')
            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                       class="w-4 h-4 rounded border-midnight-700 bg-midnight-800 text-accent-500 focus:ring-accent-500 focus:ring-offset-midnight-900">
                <span class="text-sm text-midnight-400">Remember me</span>
            </label>

            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm text-accent-500 hover:text-accent-400 transition-colors">
                Forgot password?
            </a>
            @endif
        </div>

        <button type="submit" class="btn-primary w-full justify-center">
            @if(session('pending_job'))
            Sign in & Start Monitoring
            @else
            Sign in
            @endif
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-midnight-400">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-accent-500 hover:text-accent-400 transition-colors font-medium">
                Create one
            </a>
        </p>
    </div>
</x-guest-layout>
