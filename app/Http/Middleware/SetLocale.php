<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported locales
     */
    protected array $supportedLocales = ['en', 'tr', 'de'];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Priority: 1. User preference, 2. Session, 3. Browser, 4. Default
        $locale = $this->determineLocale($request);
        
        App::setLocale($locale);
        
        // Store in session for guests
        if (!Auth::check()) {
            session(['locale' => $locale]);
        }
        
        return $next($request);
    }

    /**
     * Determine the locale to use
     */
    protected function determineLocale(Request $request): string
    {
        // 1. Check authenticated user's preference
        if (Auth::check() && Auth::user()->locale) {
            $locale = Auth::user()->locale;
            if (in_array($locale, $this->supportedLocales)) {
                return $locale;
            }
        }

        // 2. Check session
        if (session()->has('locale')) {
            $locale = session('locale');
            if (in_array($locale, $this->supportedLocales)) {
                return $locale;
            }
        }

        // 3. Check URL parameter (for switching)
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            if (in_array($locale, $this->supportedLocales)) {
                session(['locale' => $locale]);
                return $locale;
            }
        }

        // 4. Check browser preference
        $browserLocale = $this->getBrowserLocale($request);
        if ($browserLocale && in_array($browserLocale, $this->supportedLocales)) {
            return $browserLocale;
        }

        // 5. Default locale
        return config('app.locale', 'en');
    }

    /**
     * Get browser's preferred locale
     */
    protected function getBrowserLocale(Request $request): ?string
    {
        $acceptLanguage = $request->header('Accept-Language');
        
        if (!$acceptLanguage) {
            return null;
        }

        // Parse Accept-Language header
        $languages = explode(',', $acceptLanguage);
        
        foreach ($languages as $language) {
            $parts = explode(';', $language);
            $locale = trim($parts[0]);
            
            // Get first two characters (language code)
            $shortLocale = substr($locale, 0, 2);
            
            if (in_array($shortLocale, $this->supportedLocales)) {
                return $shortLocale;
            }
        }

        return null;
    }
}


