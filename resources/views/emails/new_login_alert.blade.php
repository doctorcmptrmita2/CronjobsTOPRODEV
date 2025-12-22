<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Login Alert</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #0f172a; color: #e2e8f0; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; padding: 40px 20px;">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px;">
            @if($loginHistory->is_suspicious)
            <div style="display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 8px;">
                <span style="font-size: 24px; font-weight: bold; color: #ffffff;">⚠️ SUSPICIOUS LOGIN</span>
            </div>
            @else
            <div style="display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 8px;">
                <span style="font-size: 24px; font-weight: bold; color: #ffffff;">🔐 NEW LOGIN</span>
            </div>
            @endif
        </div>

        <!-- Main Card -->
        <div style="background-color: #1e293b; border-radius: 12px; padding: 30px; border: 1px solid #334155;">
            <h1 style="font-size: 24px; font-weight: 600; color: #f1f5f9; margin: 0 0 10px 0;">
                Hello {{ $user->name }},
            </h1>
            
            <p style="color: #94a3b8; font-size: 16px; margin: 0 0 25px 0;">
                @if($loginHistory->is_suspicious)
                We detected a suspicious login to your account from a new device and location.
                @elseif($loginHistory->is_new_device)
                We detected a login to your account from a new device.
                @else
                We detected a login to your account from a new location.
                @endif
            </p>

            <div style="background-color: #0f172a; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 10px 0; color: #94a3b8; font-size: 14px;">
                            <span style="margin-right: 8px;">📅</span> Time
                        </td>
                        <td style="padding: 10px 0; color: #f1f5f9; font-size: 14px; text-align: right;">
                            {{ $loginHistory->logged_in_at->format('M d, Y \a\t H:i:s') }} UTC
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; color: #94a3b8; font-size: 14px;">
                            <span style="margin-right: 8px;">📍</span> Location
                        </td>
                        <td style="padding: 10px 0; color: #f1f5f9; font-size: 14px; text-align: right;">
                            {{ $loginHistory->location ?? 'Unknown' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; color: #94a3b8; font-size: 14px;">
                            <span style="margin-right: 8px;">🌐</span> IP Address
                        </td>
                        <td style="padding: 10px 0; color: #f1f5f9; font-size: 14px; text-align: right; font-family: monospace;">
                            {{ $loginHistory->ip_address }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; color: #94a3b8; font-size: 14px;">
                            <span style="margin-right: 8px;">💻</span> Device
                        </td>
                        <td style="padding: 10px 0; color: #f1f5f9; font-size: 14px; text-align: right;">
                            {{ ucfirst($loginHistory->device_type) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; color: #94a3b8; font-size: 14px;">
                            <span style="margin-right: 8px;">🔍</span> Browser
                        </td>
                        <td style="padding: 10px 0; color: #f1f5f9; font-size: 14px; text-align: right;">
                            {{ $loginHistory->browser }} on {{ $loginHistory->platform }}
                        </td>
                    </tr>
                </table>
            </div>

            @if($loginHistory->is_suspicious)
            <div style="background-color: #7f1d1d; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <p style="margin: 0; color: #fecaca; font-size: 14px;">
                    <strong>⚠️ If this wasn't you:</strong> Please change your password immediately and review your account activity.
                </p>
            </div>
            @endif

            <div style="text-align: center;">
                <a href="{{ url('/settings/account') }}" 
                   style="display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; margin-right: 10px;">
                    Review Account Settings
                </a>
                @if($loginHistory->is_suspicious)
                <a href="{{ url('/settings/account') }}" 
                   style="display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px;">
                    Change Password
                </a>
                @endif
            </div>
        </div>

        <!-- Security Tips -->
        <div style="background-color: #1e293b; border-radius: 12px; padding: 20px; margin-top: 20px; border: 1px solid #334155;">
            <h3 style="font-size: 14px; font-weight: 600; color: #f1f5f9; margin: 0 0 15px 0;">
                🛡️ Security Tips
            </h3>
            <ul style="margin: 0; padding-left: 20px; color: #94a3b8; font-size: 13px;">
                <li style="margin-bottom: 8px;">Use a strong, unique password for your account</li>
                <li style="margin-bottom: 8px;">Enable two-factor authentication for extra security</li>
                <li style="margin-bottom: 8px;">Never share your login credentials with anyone</li>
                <li>Review your recent login activity regularly</li>
            </ul>
        </div>

        <!-- Footer -->
        <div style="text-align: center; margin-top: 30px; color: #64748b; font-size: 12px;">
            <p>You received this alert because login notifications are enabled for your account.</p>
            <p>To disable these alerts, visit your <a href="{{ url('/settings/notifications') }}" style="color: #6366f1;">notification settings</a>.</p>
            <p>© {{ date('Y') }} Cronjobs.to - Secure Cron Job Monitoring</p>
        </div>
    </div>
</body>
</html>


