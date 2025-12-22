<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use PragmaRX\Google2FAQRCode\Google2FA as Google2FAQRCode;

class TwoFactorService
{
    protected Google2FA $google2fa;
    protected Google2FAQRCode $google2faQR;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
        $this->google2faQR = new Google2FAQRCode();
    }

    /**
     * Generate a new secret key for the user
     */
    public function generateSecretKey(): string
    {
        return $this->google2fa->generateSecretKey();
    }

    /**
     * Get QR code image URL for the user
     */
    public function getQrCodeUrl(User $user, string $secret): string
    {
        $appName = config('app.name', 'Cronjobs.to');
        
        return $this->google2faQR->getQRCodeInline(
            $appName,
            $user->email,
            $secret
        );
    }

    /**
     * Verify a TOTP code
     */
    public function verify(string $secret, string $code): bool
    {
        return $this->google2fa->verifyKey($secret, $code);
    }

    /**
     * Generate recovery codes
     */
    public function generateRecoveryCodes(): array
    {
        return Collection::times(8, function () {
            return Str::random(10) . '-' . Str::random(10);
        })->all();
    }

    /**
     * Enable 2FA for a user
     */
    public function enable(User $user, string $secret, string $code): bool
    {
        if (!$this->verify($secret, $code)) {
            return false;
        }

        $recoveryCodes = $this->generateRecoveryCodes();

        $user->update([
            'two_factor_secret' => encrypt($secret),
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
            'two_factor_confirmed_at' => now(),
        ]);

        return true;
    }

    /**
     * Disable 2FA for a user
     */
    public function disable(User $user): void
    {
        $user->update([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);
    }

    /**
     * Get recovery codes for a user
     */
    public function getRecoveryCodes(User $user): array
    {
        if (!$user->two_factor_recovery_codes) {
            return [];
        }

        return json_decode(decrypt($user->two_factor_recovery_codes), true) ?? [];
    }

    /**
     * Regenerate recovery codes
     */
    public function regenerateRecoveryCodes(User $user): array
    {
        $recoveryCodes = $this->generateRecoveryCodes();

        $user->update([
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        ]);

        return $recoveryCodes;
    }

    /**
     * Verify user with code or recovery code
     */
    public function verifyCode(User $user, string $code): bool
    {
        if (!$user->two_factor_secret) {
            return false;
        }

        $secret = decrypt($user->two_factor_secret);

        // Try TOTP code first
        if ($this->verify($secret, $code)) {
            return true;
        }

        // Try recovery code
        return $this->useRecoveryCode($user, $code);
    }

    /**
     * Use a recovery code
     */
    protected function useRecoveryCode(User $user, string $code): bool
    {
        $recoveryCodes = $this->getRecoveryCodes($user);

        if (!in_array($code, $recoveryCodes)) {
            return false;
        }

        // Remove used recovery code
        $remainingCodes = array_values(array_filter($recoveryCodes, fn($c) => $c !== $code));
        
        $user->update([
            'two_factor_recovery_codes' => encrypt(json_encode($remainingCodes)),
        ]);

        return true;
    }

    /**
     * Check if user has 2FA enabled
     */
    public function isEnabled(User $user): bool
    {
        return $user->two_factor_confirmed_at !== null;
    }
}


