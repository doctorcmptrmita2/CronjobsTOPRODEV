<x-mail::message>
# {{ $isHeartbeat ? '💚 Heartbeat Recovered' : '✅ Job Recovered' }}

Good news! Your {{ $isHeartbeat ? 'heartbeat' : 'job' }} **{{ $job->name }}** is back to healthy status.

@if($isHeartbeat)
**Last Ping:** {{ $job->last_ping_at?->format('M d, Y H:i:s T') ?? 'Just now' }}

**Expected Interval:** Every {{ $job->heartbeat_interval }} minutes

The heartbeat monitoring is now receiving pings again as expected.
@else
**Last Run:** {{ $job->last_run_at?->format('M d, Y H:i:s T') ?? 'N/A' }}

**Status Code:** {{ $job->last_status_code }}

The job is now executing successfully.
@endif

<x-mail::button :url="route('jobs.show', $job)">
View {{ $isHeartbeat ? 'Heartbeat' : 'Job' }} Details
</x-mail::button>

---

You're receiving this because you have alert notifications enabled for this {{ $isHeartbeat ? 'heartbeat' : 'job' }}.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>







