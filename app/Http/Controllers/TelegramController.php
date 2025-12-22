<?php

namespace App\Http\Controllers;

use App\Services\TelegramService;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function __construct(
        protected TelegramService $telegram
    ) {}

    /**
     * Show Telegram settings page
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $botInfo = $this->telegram->getBotInfo();
        $botUsername = $botInfo['username'] ?? config('services.telegram.bot_username');

        return view('settings.telegram', [
            'user' => $user,
            'botUsername' => $botUsername,
            'isConfigured' => $this->telegram->isConfigured(),
        ]);
    }

    /**
     * Generate verification code and show instructions
     */
    public function connect(Request $request)
    {
        $user = $request->user();
        $code = $this->telegram->generateVerificationCode($user);
        $botUsername = config('services.telegram.bot_username');

        return back()->with([
            'verification_code' => $code,
            'bot_username' => $botUsername,
        ]);
    }

    /**
     * Disconnect Telegram
     */
    public function disconnect(Request $request)
    {
        $this->telegram->disconnect($request->user());

        return back()->with('success', 'Telegram disconnected successfully.');
    }

    /**
     * Handle Telegram webhook
     */
    public function webhook(Request $request)
    {
        $update = $request->all();

        // Handle message
        if (isset($update['message'])) {
            $message = $update['message'];
            $chatId = $message['chat']['id'];
            $text = $message['text'] ?? '';
            $username = $message['from']['username'] ?? null;

            // Handle /start command
            if (str_starts_with($text, '/start')) {
                $this->handleStartCommand($chatId, $text, $username);
            }
            // Handle /verify command
            elseif (str_starts_with($text, '/verify')) {
                $this->handleVerifyCommand($chatId, $text, $username);
            }
            // Handle plain verification code
            elseif (preg_match('/^[A-Z0-9]{6}$/', trim($text))) {
                $this->handleVerificationCode($chatId, trim($text), $username);
            }
            // Handle /status command
            elseif ($text === '/status') {
                $this->handleStatusCommand($chatId);
            }
            // Handle /help command
            elseif ($text === '/help') {
                $this->handleHelpCommand($chatId);
            }
        }

        return response('OK', 200);
    }

    /**
     * Handle /start command
     */
    protected function handleStartCommand(string $chatId, string $text, ?string $username): void
    {
        // Check if there's a verification code in the start parameter
        $parts = explode(' ', $text);
        if (count($parts) > 1) {
            $code = $parts[1];
            $this->handleVerificationCode($chatId, $code, $username);
            return;
        }

        $message = "👋 <b>Welcome to Cronjobs.to Bot!</b>\n\n";
        $message .= "I'll send you alerts for your cron jobs, uptime monitors, and account security.\n\n";
        $message .= "<b>To connect your account:</b>\n";
        $message .= "1. Go to your Cronjobs.to settings\n";
        $message .= "2. Click 'Connect Telegram'\n";
        $message .= "3. Send the verification code here\n\n";
        $message .= "Or use /verify YOUR_CODE";

        $this->telegram->sendMessage($chatId, $message);
    }

    /**
     * Handle /verify command
     */
    protected function handleVerifyCommand(string $chatId, string $text, ?string $username): void
    {
        $parts = explode(' ', trim($text));
        
        if (count($parts) < 2) {
            $this->telegram->sendMessage($chatId, 
                "❌ Please provide your verification code.\n\n" .
                "Usage: /verify YOUR_CODE"
            );
            return;
        }

        $code = strtoupper($parts[1]);
        $this->handleVerificationCode($chatId, $code, $username);
    }

    /**
     * Handle verification code
     */
    protected function handleVerificationCode(string $chatId, string $code, ?string $username): void
    {
        $user = $this->telegram->verifyUser($code, $chatId, $username);

        if (!$user) {
            $this->telegram->sendMessage($chatId,
                "❌ <b>Invalid verification code.</b>\n\n" .
                "Please make sure you entered the correct code from your Cronjobs.to settings."
            );
        }
        // Success message is sent by the service
    }

    /**
     * Handle /status command
     */
    protected function handleStatusCommand(string $chatId): void
    {
        $user = \App\Models\User::where('telegram_chat_id', $chatId)->first();

        if (!$user) {
            $this->telegram->sendMessage($chatId,
                "❌ <b>Not Connected</b>\n\n" .
                "This Telegram account is not connected to any Cronjobs.to account.\n\n" .
                "Use /start to learn how to connect."
            );
            return;
        }

        $jobCount = $user->jobs()->where('is_active', true)->count();
        $checkCount = $user->checks()->where('is_active', true)->count();
        $failingJobs = $user->jobs()->where('consecutive_failures', '>', 0)->count();
        $downChecks = $user->checks()->where('is_up', false)->count();

        $message = "📊 <b>Your Cronjobs.to Status</b>\n\n";
        $message .= "Account: {$user->email}\n";
        $message .= "Connected: " . $user->telegram_verified_at->format('M d, Y') . "\n\n";
        $message .= "<b>Monitoring:</b>\n";
        $message .= "• Active Jobs: {$jobCount}\n";
        $message .= "• Uptime Checks: {$checkCount}\n\n";
        
        if ($failingJobs > 0 || $downChecks > 0) {
            $message .= "⚠️ <b>Issues:</b>\n";
            if ($failingJobs > 0) {
                $message .= "• {$failingJobs} jobs with failures\n";
            }
            if ($downChecks > 0) {
                $message .= "• {$downChecks} endpoints down\n";
            }
        } else {
            $message .= "✅ All systems operational!";
        }

        $this->telegram->sendMessage($chatId, $message);
    }

    /**
     * Handle /help command
     */
    protected function handleHelpCommand(string $chatId): void
    {
        $message = "📚 <b>Available Commands</b>\n\n";
        $message .= "/start - Welcome message and setup instructions\n";
        $message .= "/verify CODE - Connect your Cronjobs.to account\n";
        $message .= "/status - View your monitoring status\n";
        $message .= "/help - Show this help message\n\n";
        $message .= "You can also send your 6-character verification code directly.\n\n";
        $message .= "🔗 <a href=\"" . url('/settings/telegram') . "\">Manage Settings</a>";

        $this->telegram->sendMessage($chatId, $message);
    }

    /**
     * Test Telegram connection
     */
    public function test(Request $request)
    {
        $user = $request->user();

        if (!$user->telegram_enabled || !$user->telegram_chat_id) {
            return back()->with('error', 'Telegram is not connected.');
        }

        $result = $this->telegram->sendMessage($user->telegram_chat_id,
            "🧪 <b>Test Message</b>\n\n" .
            "This is a test notification from Cronjobs.to.\n" .
            "Your Telegram alerts are working correctly! ✅"
        );

        if ($result) {
            return back()->with('success', 'Test message sent successfully!');
        }

        return back()->with('error', 'Failed to send test message. Please try again.');
    }
}


