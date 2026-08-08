<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    protected array $supportedLocales = ['ar', 'fr', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = null;

        // 1. URL Query parameter: ?lang=ar|fr|en  (highest priority)
        if ($request->has('lang') && in_array($request->query('lang'), $this->supportedLocales)) {
            $locale = $request->query('lang');
            Session::put('locale', $locale);

            // Persist to user profile if authenticated
            if ($user = $request->user()) {
                $user->update(['locale' => $locale]);
            }
        }

        // 2. Session (set by lang.switch route OR ?lang= param above)
        if (!$locale && Session::has('locale') && in_array(Session::get('locale'), $this->supportedLocales)) {
            $locale = Session::get('locale');
        }

        // 3. Authenticated User DB preference (fallback if session is empty)
        if (!$locale && $request->user() && in_array($request->user()->locale, $this->supportedLocales)) {
            $locale = $request->user()->locale;
            // Sync session with DB preference
            Session::put('locale', $locale);
        }

        // 4. Accept-Language header
        if (!$locale) {
            $acceptLang = substr($request->header('Accept-Language', ''), 0, 2);
            if (in_array($acceptLang, $this->supportedLocales)) {
                $locale = $acceptLang;
            }
        }

        // 5. Config default fallback
        if (!$locale) {
            $locale = config('app.locale', 'ar');
        }

        // Apply locale globally
        App::setLocale($locale);
        config(['app.locale' => $locale]);

        return $next($request);
    }
}
