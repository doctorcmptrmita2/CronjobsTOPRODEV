<div style="font-family: Arial, sans-serif; color: #111; line-height: 1.6;">
    <h2 style="margin-bottom: 8px;">Cronjobs.to - Job Failure Alert</h2>
    <p>Merhaba {{ $user->name }},</p>
    <p><strong>{{ $job->name }}</strong> job'ı ardışık hatalara ulaştı.</p>

    <ul>
        <li>Failure count: {{ $job->consecutive_failures }}</li>
        <li>Last status: {{ $job->last_status_code ?? 'N/A' }}</li>
        <li>Last error: {{ $job->last_error_message ?? '—' }}</li>
        <li>URL: {{ $job->url }}</li>
    </ul>

    <p>Job'u kontrol etmek için giriş yapın.</p>
</div>

