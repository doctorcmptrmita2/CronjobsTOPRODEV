<?php

namespace App\Http\Controllers;

use App\Services\TwoFactorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TwoFactorController extends Controller
{
    public function __construct(
        protected TwoFactorService $twoFactor
    ) {}

    /**
     * Show 2FA settings page
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $isEnabled = $this->twoFactor->isEnabled($user);

        return view('settings.two-factor', [
            'user' => $user,
            'isEnabled' => $isEnabled,
        ]);
    }

    /**
     * Show 2FA setup page
     */
    public function setup(Request $request)
    {
        $user = $request->user();

        if ($this->twoFactor->isEnabled($user)) {
            return redirect()->route('settings.two-factor');
        }

        // Generate or get existing secret from session
        $secret = session('two_factor_secret');
        if (!$secret) {
            $secret = $this->twoFactor->generateSecretKey();
            session(['two_factor_secret' => $secret]);
        }

        $qrCodeUrl = $this->twoFactor->getQrCodeUrl($user, $secret);

        return view('settings.two-factor-setup', [
            'user' => $user,
            'secret' => $secret,
            'qrCodeUrl' => $qrCodeUrl,
        ]);
    }

    /**
     * Enable 2FA
     */
    public function enable(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = $request->user();
        $secret = session('two_factor_secret');

        if (!$secret) {
            return back()->with('error', 'Please start the setup process again.');
        }

        if ($this->twoFactor->enable($user, $secret, $request->code)) {
            session()->forget('two_factor_secret');
            
            // Show recovery codes
            $recoveryCodes = $this->twoFactor->getRecoveryCodes($user);
            
            return redirect()->route('settings.two-factor.recovery-codes')
                ->with('recovery_codes', $recoveryCodes)
                ->with('success', 'Two-factor authentication has been enabled.');
        }

        return back()->with('error', 'Invalid verification code. Please try again.');
    }

    /**
     * Show recovery codes
     */
    public function recoveryCodes(Request $request)
    {
        $user = $request->user();

        if (!$this->twoFactor->isEnabled($user)) {
            return redirect()->route('settings.two-factor');
        }

        $recoveryCodes = session('recovery_codes') ?? $this->twoFactor->getRecoveryCodes($user);

        return view('settings.two-factor-recovery', [
            'user' => $user,
            'recoveryCodes' => $recoveryCodes,
            'justEnabled' => session()->has('recovery_codes'),
        ]);
    }

    /**
     * Regenerate recovery codes
     */
    public function regenerateRecoveryCodes(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = $request->user();

        if (!$this->twoFactor->isEnabled($user)) {
            return redirect()->route('settings.two-factor');
        }

        $recoveryCodes = $this->twoFactor->regenerateRecoveryCodes($user);

        return redirect()->route('settings.two-factor.recovery-codes')
            ->with('recovery_codes', $recoveryCodes)
            ->with('success', 'Recovery codes have been regenerated.');
    }

    /**
     * Disable 2FA
     */
    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = $request->user();
        $this->twoFactor->disable($user);

        return redirect()->route('settings.two-factor')
            ->with('success', 'Two-factor authentication has been disabled.');
    }

    /**
     * Show 2FA challenge page (during login)
     */
    public function challenge(Request $request)
    {
        if (!$request->session()->has('login.id')) {
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge');
    }

    /**
     * Verify 2FA during login
     */
    public function verifyChallenge(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $userId = $request->session()->get('login.id');
        
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = \App\Models\User::find($userId);
        
        if (!$user || !$this->twoFactor->verifyCode($user, $request->code)) {
            return back()->with('error', 'Invalid verification code.');
        }

        // Clear the session data
        $request->session()->forget('login.id');
        $request->session()->forget('login.remember');

        // Log the user in
        auth()->login($user, $request->session()->get('login.remember', false));
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}


