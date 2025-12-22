<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestJobController;
use App\Http\Controllers\HeartbeatController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobRunController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\LoginHistoryController;
use App\Http\Controllers\StatusPageController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('landing');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::view('/docs', 'pages.docs')->name('docs');

// Telegram webhook (no CSRF)
Route::post('/webhook/telegram', [TelegramController::class, 'webhook'])->name('telegram.webhook');

// Two-Factor Authentication Challenge
Route::get('/two-factor-challenge', [TwoFactorController::class, 'challenge'])->name('two-factor.challenge');
Route::post('/two-factor-challenge', [TwoFactorController::class, 'verifyChallenge'])->name('two-factor.verify');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/system-status', [PageController::class, 'status'])->name('system-status');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');

// Guest job preview system (try before signup)
Route::post('/try', [GuestJobController::class, 'preview'])->name('guest.preview');
Route::get('/preview', [GuestJobController::class, 'dashboard'])->name('guest.dashboard');
Route::post('/preview/test', [GuestJobController::class, 'testRun'])->name('guest.test-run');
Route::post('/preview/save', [GuestJobController::class, 'saveJob'])->name('guest.save-job');

// Public status page
Route::get('/status/{slug}', [StatusPageController::class, 'show'])->name('status.public');

// Health check endpoint (for Docker/Dokploy health checks)
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toIso8601String(),
        'service' => 'cronjobs',
    ], 200);
})->name('health')->withoutMiddleware(['web']);

// Heartbeat ping endpoints (public, no auth required)
Route::match(['get', 'post', 'head'], '/ping/{token}', [HeartbeatController::class, 'ping'])
    ->name('heartbeat.ping')
    ->withoutMiddleware(['web']); // Minimal middleware for performance
Route::get('/ping/{token}/status', [HeartbeatController::class, 'status'])
    ->name('heartbeat.status');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Jobs
    Route::resource('jobs', JobController::class);
    Route::patch('jobs/{job}/toggle', [JobController::class, 'toggle'])->name('jobs.toggle');
    Route::post('jobs/{job}/run-now', [JobController::class, 'runNow'])->name('jobs.run-now');
    Route::get('jobs/{job}/runs/{run}', [JobRunController::class, 'show'])
        ->scopeBindings()
        ->name('jobs.runs.show');

    // Statistics
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');

    // Activity Log
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
    Route::get('/activity-log/{id}', [ActivityLogController::class, 'show'])->name('activity-log.show');

    // Uptime Monitoring
    Route::resource('uptime', CheckController::class)->parameters(['uptime' => 'check']);
    Route::patch('uptime/{check}/toggle', [CheckController::class, 'toggle'])->name('uptime.toggle');
    Route::post('uptime/{check}/run-now', [CheckController::class, 'runNow'])->name('uptime.run-now');

    // Status Pages
    Route::resource('status-pages', StatusPageController::class)->except(['show']);

    // Settings
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings');
        Route::get('/account', [SettingsController::class, 'account'])->name('settings.account');
        Route::put('/account', [SettingsController::class, 'updateAccount'])->name('settings.account.update');
        Route::get('/api', [SettingsController::class, 'api'])->name('settings.api');
        Route::post('/api/generate', [SettingsController::class, 'generateApiToken'])->name('settings.api.generate');
        Route::post('/api/regenerate', [SettingsController::class, 'regenerateApiToken'])->name('settings.api.regenerate');
        Route::get('/notifications', [SettingsController::class, 'notifications'])->name('settings.notifications');
        Route::put('/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
        Route::get('/login-history', [LoginHistoryController::class, 'index'])->name('settings.login-history');
        
        // Telegram settings
        Route::get('/telegram', [TelegramController::class, 'index'])->name('settings.telegram');
        Route::post('/telegram/connect', [TelegramController::class, 'connect'])->name('settings.telegram.connect');
        Route::delete('/telegram/disconnect', [TelegramController::class, 'disconnect'])->name('settings.telegram.disconnect');
        Route::post('/telegram/test', [TelegramController::class, 'test'])->name('settings.telegram.test');
        
        // Two-Factor Authentication settings
        Route::get('/two-factor', [TwoFactorController::class, 'index'])->name('settings.two-factor');
        Route::get('/two-factor/setup', [TwoFactorController::class, 'setup'])->name('settings.two-factor.setup');
        Route::post('/two-factor/enable', [TwoFactorController::class, 'enable'])->name('settings.two-factor.enable');
        Route::delete('/two-factor/disable', [TwoFactorController::class, 'disable'])->name('settings.two-factor.disable');
        Route::get('/two-factor/recovery-codes', [TwoFactorController::class, 'recoveryCodes'])->name('settings.two-factor.recovery-codes');
        Route::post('/two-factor/regenerate-codes', [TwoFactorController::class, 'regenerateRecoveryCodes'])->name('settings.two-factor.regenerate-codes');
    });
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/jobs', [AdminJobController::class, 'index'])->name('admin.jobs.index');
});

require __DIR__.'/auth.php';
