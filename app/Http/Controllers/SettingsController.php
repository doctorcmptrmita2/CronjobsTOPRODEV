<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountUpdateRequest;
use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        return view('settings.index', [
            'user' => $request->user(),
        ]);
    }

    public function account(Request $request)
    {
        return view('settings.account', [
            'user' => $request->user(),
        ]);
    }

    public function updateAccount(AccountUpdateRequest $request)
    {
        $user = $request->user();
        $user->update($request->validated());

        return back()->with('success', 'Account updated successfully.');
    }

    public function api(Request $request)
    {
        $token = $request->user()->apiToken;

        return view('settings.api', [
            'token' => $token,
        ]);
    }

    public function generateApiToken(Request $request)
    {
        $user = $request->user();
        $plainToken = Str::random(60);

        ApiToken::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => 'Default',
                'token' => hash('sha256', $plainToken),
            ]
        );

        return back()->with('new_token', $plainToken)->with('success', 'API token created.');
    }

    public function regenerateApiToken(Request $request)
    {
        $user = $request->user();
        $plainToken = Str::random(60);

        ApiToken::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => 'Default',
                'token' => hash('sha256', $plainToken),
                'last_used_at' => null,
            ]
        );

        return back()->with('new_token', $plainToken)->with('success', 'API token regenerated.');
    }

    public function notifications(Request $request)
    {
        return view('settings.notifications', [
            'user' => $request->user(),
        ]);
    }

    public function updateNotifications(Request $request)
    {
        $validated = $request->validate([
            'notification_email' => 'nullable|email|max:255',
        ]);

        $request->user()->update($validated);

        return back()->with('success', 'Notification settings updated.');
    }
}
