<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Check Recovered</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #0f172a; color: #e2e8f0; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; padding: 40px 20px;">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 8px;">
                <span style="font-size: 24px; font-weight: bold; color: #ffffff;">🟢 RECOVERED</span>
            </div>
        </div>

        <!-- Main Card -->
        <div style="background-color: #1e293b; border-radius: 12px; padding: 30px; border: 1px solid #334155;">
            <h1 style="font-size: 24px; font-weight: 600; color: #f1f5f9; margin: 0 0 20px 0;">
                {{ $check->name }} is back online
            </h1>

            <div style="background-color: #0f172a; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #94a3b8; font-size: 14px;">URL</td>
                        <td style="padding: 8px 0; color: #f1f5f9; font-size: 14px; text-align: right; font-family: monospace;">{{ $check->url }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #94a3b8; font-size: 14px;">Recovered At</td>
                        <td style="padding: 8px 0; color: #10b981; font-size: 14px; text-align: right; font-weight: 600;">{{ now()->format('M d, Y H:i:s') }} UTC</td>
                    </tr>
                    @if($check->last_down_at)
                    <tr>
                        <td style="padding: 8px 0; color: #94a3b8; font-size: 14px;">Downtime Duration</td>
                        <td style="padding: 8px 0; color: #f1f5f9; font-size: 14px; text-align: right;">{{ $check->last_down_at->diffForHumans(now(), ['parts' => 2]) }}</td>
                    </tr>
                    @endif
                    @if($check->last_response_time_ms)
                    <tr>
                        <td style="padding: 8px 0; color: #94a3b8; font-size: 14px;">Response Time</td>
                        <td style="padding: 8px 0; color: #f1f5f9; font-size: 14px; text-align: right;">{{ $check->last_response_time_ms }}ms</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding: 8px 0; color: #94a3b8; font-size: 14px;">Uptime (24h)</td>
                        <td style="padding: 8px 0; color: #10b981; font-size: 14px; text-align: right; font-weight: 600;">{{ number_format($check->uptime_percentage, 2) }}%</td>
                    </tr>
                </table>
            </div>

            <a href="{{ url('/uptime/' . $check->id) }}" 
               style="display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px;">
                View Check Details →
            </a>
        </div>

        <!-- Footer -->
        <div style="text-align: center; margin-top: 30px; color: #64748b; font-size: 12px;">
            <p>You received this notification because you have email alerts enabled for this check.</p>
            <p>© {{ date('Y') }} Cronjobs.to - Uptime Monitoring</p>
        </div>
    </div>
</body>
</html>






