<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestJobController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobRunController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\StatusPageController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('landing');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Jobs
    Route::resource('jobs', JobController::class);
    Route::post('jobs/{job}/toggle', [JobController::class, 'toggle'])->name('jobs.toggle');
    Route::post('jobs/{job}/run-now', [JobController::class, 'runNow'])->name('jobs.run-now');
    Route::get('jobs/{job}/runs/{run}', [JobRunController::class, 'show'])
        ->scopeBindings()
        ->name('jobs.runs.show');

    // Statistics
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');

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
    });
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/jobs', [AdminJobController::class, 'index'])->name('admin.jobs.index');
});

require __DIR__.'/auth.php';
