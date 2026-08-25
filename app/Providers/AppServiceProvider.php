<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\CountryDelegation;
use App\Models\Registration;
use App\Policies\CountryPolicy;
use App\Policies\DelegationPolicy;
use App\Policies\ParticipantPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Trust reverse proxies (aaPanel / NGINX / Cloudflare / HTTPS SSL termination)
        Request::setTrustedProxies(
            ['*'],
            Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO |
            Request::HEADER_X_FORWARDED_AWS_ELB
        );

        \Illuminate\Support\Facades\URL::forceScheme('https');
        if (config('app.url')) {
            \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url'));
        }

        if (app()->environment('production') || request()->header('X-Forwarded-Proto') === 'https' || str_contains(config('app.url', ''), 'https')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }


        \Illuminate\Support\Facades\Blade::directive('assetv', function ($expression) {
            return "<?php echo \App\Services\SettingsEngine::appendCacheBuster(asset($expression)); ?>";
        });

        if (class_exists(\Livewire\Livewire::class)) {
            \Livewire\Livewire::setScriptRoute(function ($handle) {
                return \Illuminate\Support\Facades\Route::get('/livewire/livewire.js', $handle);
            });
            \Livewire\Livewire::setUpdateRoute(function ($handle) {
                return \Illuminate\Support\Facades\Route::post('/livewire/update', $handle);
            });
            if (method_exists(\Livewire\Livewire::class, 'setUploadRoute')) {
                \Livewire\Livewire::setUploadRoute(function ($handle) {
                    return \Illuminate\Support\Facades\Route::post('/livewire/upload-file', $handle);
                });
            }
        }

        Gate::policy(Country::class, CountryPolicy::class);
        Gate::policy(CountryDelegation::class, DelegationPolicy::class);
        Gate::policy(Registration::class, ParticipantPolicy::class);

        // Named Rate Limiters
        RateLimiter::for('verify', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip());
        });

        RateLimiter::for('certificate', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip());
        });

        RateLimiter::for('registration', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });
    }
}
