<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isSecure() && $request->header('x-forwarded-proto') !== 'https') {
            if (app()->environment('production') || str_contains($request->getHost(), 'worldskills.dz')) {
                return redirect()->secure($request->getRequestUri(), 301);
            }
        }

        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set(
            'Content-Security-Policy',
            "upgrade-insecure-requests; default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval'; base-uri 'self'; object-src 'self' data: blob: http: https:; frame-ancestors 'self'; form-action 'self' https: http:; img-src 'self' data: https: http: blob:; font-src 'self' data: https: http:; connect-src 'self' https: http: wss: ws:; script-src 'self' 'unsafe-inline' 'unsafe-eval' https: http:; style-src 'self' 'unsafe-inline' https: http:;"
        );

        return $response;
    }
}
