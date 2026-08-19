<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    protected array $supportedLocales = ['ar', 'fr', 'en', 'pt'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = null;

        // 1. Explicit URL Query parameter: ?lang=ar|fr|en|pt
        if ($request->has('lang') && in_array($request->query('lang'), $this->supportedLocales)) {
            $locale = $request->query('lang');
            Session::put('locale', $locale);
            Cookie::queue(cookie()->forever('app_locale', $locale));
        }

        // 2. Session (set by lang.switch route OR ?lang= param)
        if (!$locale && Session::has('locale') && in_array(Session::get('locale'), $this->supportedLocales)) {
            $locale = Session::get('locale');
        }

        // 3. Cookie fallback
        if (!$locale && $request->hasCookie('app_locale') && in_array($request->cookie('app_locale'), $this->supportedLocales)) {
            $locale = $request->cookie('app_locale');
        }

        // 4. Authenticated User DB preference
        if (!$locale && $request->user() && in_array($request->user()->locale, $this->supportedLocales)) {
            $locale = $request->user()->locale;
        }

        // 5. Accept-Language header
        if (!$locale) {
            $acceptLang = strtolower(substr($request->header('Accept-Language', ''), 0, 2));
            if (in_array($acceptLang, $this->supportedLocales)) {
                $locale = $acceptLang;
            }
        }

        // 6. Default fallback
        if (!$locale) {
            $locale = config('app.locale', 'ar');
        }

        // Apply locale globally
        App::setLocale($locale);
        config(['app.locale' => $locale]);
        Session::put('locale', $locale);

        /** @var Response $response */
        $response = $next($request);

        // Attach cookie to response for long-term persistence across sessions
        $response->headers->setCookie(cookie()->forever('app_locale', $locale));

        return $response;
    }
}
