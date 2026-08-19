<?php

use App\Enums\RoleEnum;
use App\Livewire\Admin\AdminEventCenter;
use App\Livewire\Admin\CmsHomepageManager;
use App\Livewire\Admin\MediaManagerDashboard;
use App\Livewire\Admin\SuperAdminDashboard;
use App\Livewire\Admin\AdminUserIndex;
use App\Livewire\Admin\AdminOrganizationIndex;
use App\Livewire\Admin\AdminCountryIndex;
use App\Livewire\Admin\AdminPartnerIndex;
use App\Livewire\Admin\AdminSkillIndex;
use App\Livewire\Admin\AdminWilayaIndex;
use App\Livewire\Admin\AdminEditionIndex;
use App\Livewire\Admin\AdminRegistrationIndex;
use App\Livewire\Admin\DiplomaticCenter;
use App\Livewire\Admin\AdminNewsIndex;
use App\Livewire\Admin\AdminGalleryIndex;
use App\Livewire\Admin\AdminVideoIndex;
use App\Livewire\Admin\AdminAuditLogIndex;
use App\Livewire\Admin\AdminReportsIndex;
use App\Livewire\Admin\AdminCertificateIndex;
use App\Livewire\Admin\AdminAccreditationIndex;
use App\Livewire\Public\CertificateVerify;
use App\Livewire\Public\LiveTvDisplay;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\UserProfile;
use App\Livewire\Country\CountryDashboard;
use App\Livewire\Country\DelegationManager;
use App\Livewire\Country\DietaryManager;
use App\Livewire\Country\SkillSelectionManager;
use App\Livewire\Public\Contact;
use App\Livewire\Public\EventsIndex;
use App\Livewire\Public\Faq;
use App\Livewire\Public\GalleryIndex;
use App\Livewire\Public\GlobalSearch;
use App\Livewire\Public\Guide;
use App\Livewire\Public\Home;
use App\Livewire\Public\News;
use App\Livewire\Public\Partners;
use App\Livewire\Public\Privacy;
use App\Livewire\Public\Registration;
use App\Livewire\Public\Regulations;
use App\Livewire\Public\Results;
use App\Livewire\Public\Schedule;
use App\Livewire\Public\Skills;
use App\Livewire\Public\Terms;
use App\Livewire\Public\VideoCenter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public Portal Routes
Route::get('/', Home::class)->name('home');
Route::get('/guide', Guide::class)->name('guide');

// Redirect legacy competition/results/schedule routes to Forum Guide & Agenda
Route::get('/skills', Skills::class)->name('skills');
Route::get('/regulations', Regulations::class)->name('regulations');
Route::get('/guide-regulations', \App\Livewire\Public\GuideRegulations::class)->name('guide.regulations');
Route::get('/guide-regulations/viewer/{key?}', \App\Livewire\Public\GuideRegulations::class)->name('td.viewer');
Route::get('/schedule', Schedule::class)->name('schedule');
Route::get('/results', Results::class)->name('results');
Route::get('/news', News::class)->name('news');
Route::get('/partners', Partners::class)->name('partners');
Route::get('/contact', Contact::class)->name('contact');
Route::get('/faq', Faq::class)->name('faq');
Route::get('/registration', Registration::class)->middleware('throttle:registration')->name('registration');
Route::get('/registration/official', \App\Livewire\Public\OfficialRegistration::class)->name('official.registration');
Route::get('/login', Login::class)->middleware('throttle:login')->name('login');
Route::get('/forgot-password', \App\Livewire\Auth\ForgotPassword::class)->middleware('throttle:login')->name('password.request');
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
})->name('logout');
Route::get('/profile', UserProfile::class)->middleware('auth')->name('profile');
Route::get('/notifications', \App\Livewire\User\UserNotifications::class)->middleware('auth')->name('user.notifications');

// Legal & CMS Public Routes
Route::get('/privacy', Privacy::class)->name('privacy');
Route::get('/terms', Terms::class)->name('terms');

Route::get('/gallery', GalleryIndex::class)->name('gallery');
Route::get('/events', EventsIndex::class)->name('events');
Route::get('/videos', VideoCenter::class)->name('videos');
Route::get('/search', GlobalSearch::class)->name('search');
Route::get('/verify', \App\Livewire\Public\Verification::class)->middleware('throttle:verify')->name('verify');
Route::get('/certificate/{number}', \App\Livewire\Public\Certificate::class)->middleware('throttle:certificate')->name('certificate');
Route::get('/certificate/official/{identifier}/{type?}', \App\Livewire\Public\OfficialCertificate::class)->name('official.certificate');
Route::get('/accreditation/badge/{identifier}', \App\Livewire\Public\AccreditationBadge::class)->name('accreditation.badge');
Route::get('/my-badge', function () {
    /** @var \App\Models\User|null $user */
    $user = \Illuminate\Support\Facades\Auth::user();
    if (!$user) {
        return redirect()->route('login');
    }
    $reg = \App\Models\Registration::whereHas('participant', fn($p) => $p->where('user_id', $user->id))->first();
    $id = $reg?->registration_number ?? $user->uuid;
    return redirect()->route('accreditation.badge', ['identifier' => $id]);
})->middleware('auth')->name('my.badge');

Route::get('/my/notifications', \App\Livewire\User\UserNotifications::class)->middleware('auth')->name('my.notifications');

// PWA Routes
Route::get('/manifest.webmanifest', function () {
    return response(file_get_contents(public_path('manifest.webmanifest')), 200, [
        'Content-Type' => 'application/manifest+json'
    ]);
});
Route::get('/sw.js', function () {
    return response(file_get_contents(public_path('sw.js')), 200, [
        'Content-Type' => 'application/javascript'
    ]);
});
Route::get('/offline.html', function () {
    return response(file_get_contents(public_path('offline.html')), 200, [
        'Content-Type' => 'text/html'
    ]);
});

// Language Switcher Route
Route::match(['get', 'post'], '/lang/{locale}', function (string $locale, \Illuminate\Http\Request $request) {
    if (in_array($locale, ['ar', 'fr', 'en', 'pt'])) {
        session(['locale' => $locale]);
        session()->save();
        app()->setLocale($locale);
        if ($user = auth()->user()) {
            $user->update(['locale' => $locale]);
        }
    }

    $back = url()->previous();
    if (empty($back) || $back === $request->fullUrl()) {
        $back = route('home');
    }

    if ($request->expectsJson() || $request->header('X-Livewire')) {
        return response()->json(['status' => 'success', 'locale' => $locale, 'redirect' => $back])
            ->withCookie(cookie()->forever('app_locale', $locale));
    }

    return redirect($back)->withCookie(cookie()->forever('app_locale', $locale));
})->name('lang.switch');

// Shared CMS & Media Routes (Accessible by Super Admin & Media Manager)
Route::prefix('panel')->middleware(['auth', 'role:' . RoleEnum::SUPER_ADMIN->value . '|' . RoleEnum::MEDIA_MANAGER->value])->name('admin.')->group(function () {
    Route::get('/media/dashboard', MediaManagerDashboard::class)->name('media.dashboard');
    Route::get('/cms/news',        AdminNewsIndex::class)->name('cms.news');
    Route::get('/cms/gallery',     AdminGalleryIndex::class)->name('cms.gallery');
    Route::get('/cms/videos',      AdminVideoIndex::class)->name('cms.videos');
    Route::get('/cms/homepage',    CmsHomepageManager::class)->name('cms.homepage');
    Route::get('/cms/guide', \App\Livewire\Admin\AdminGuideCmsManager::class)->name('cms.guide');
    Route::get('/live-tv',   \App\Livewire\Admin\AdminLiveTvManager::class)->name('live-tv');
    Route::get('/appearance',      \App\Livewire\Admin\PlatformAppearanceManager::class)->name('appearance');
});

// Smart Admin Dashboard Route — Handles all admin and country admin roles seamlessly
Route::get('/panel/dashboard', function () {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login');
    }

    if ($user->hasRole(RoleEnum::SUPER_ADMIN->value) || $user->hasRole(RoleEnum::NATIONAL_ADMIN->value)) {
        return app(SuperAdminDashboard::class)();
    } elseif ($user->hasRole(RoleEnum::MEDIA_MANAGER->value)) {
        return redirect()->route('admin.media.dashboard');
    } elseif ($user->hasRole(RoleEnum::COUNTRY_ADMIN->value)) {
        return redirect()->route('country.dashboard');
    }

    return redirect()->route('home');
})->middleware('auth')->name('admin.dashboard');

// Super Admin Command Center Routes
Route::prefix('panel')->middleware(['auth', 'role:' . RoleEnum::SUPER_ADMIN->value])->name('admin.')->group(function () {
    Route::get('/users', AdminUserIndex::class)->name('users');
    Route::get('/participants', function () { return redirect()->route('admin.registrations'); })->name('participants');
    Route::get('/organizations', AdminOrganizationIndex::class)->name('organizations');
    Route::get('/countries', AdminCountryIndex::class)->name('countries');
    Route::get('/delegation-invitations', \App\Livewire\Admin\DelegationInvitationsIndex::class)->name('delegation.invitations');
    Route::get('/delegation-invitations/print/{countryId}', [\App\Http\Controllers\Admin\DelegationInvitationPrintController::class, 'printSingle'])->name('delegation.invitations.print.single');
    Route::get('/partners', AdminPartnerIndex::class)->name('partners');
    Route::get('/skills',          AdminSkillIndex::class)->name('skills');
    Route::get('/wilayas',         AdminWilayaIndex::class)->name('wilayas');
    Route::get('/editions',        AdminEditionIndex::class)->name('editions');
    Route::get('/registrations',   AdminRegistrationIndex::class)->name('registrations');
    Route::get('/judges',          function () { return redirect()->route('admin.registrations', ['filterRole' => 'EXPERT']); })->name('judges');
    Route::get('/diplomatic',      DiplomaticCenter::class)->name('diplomatic');
    Route::get('/audit',           AdminAuditLogIndex::class)->name('audit');
    Route::get('/reports',         AdminReportsIndex::class)->name('reports');
    Route::get('/events', AdminEventCenter::class)->name('events');
    Route::get('/cms/legal', \App\Livewire\Admin\LegalCmsManager::class)->name('cms.legal');

    Route::get('/notifications', \App\Livewire\Admin\Notifications\NotificationIndex::class)->name('notifications.index');
    Route::get('/notifications/create', \App\Livewire\Admin\Notifications\NotificationCreate::class)->name('notifications.create');
    Route::get('/operations', \App\Livewire\Admin\FieldOperationsDashboard::class)->name('operations');
    Route::get('/arrivals', \App\Livewire\Admin\AdminArrivalsCenter::class)->name('arrivals');

    // Accreditation & Security Layer
    Route::get('/certificates',     AdminCertificateIndex::class)->name('certificates');
    Route::get('/accreditations',   AdminAccreditationIndex::class)->name('accreditations');
    Route::get('/accreditations/print', \App\Livewire\Admin\BulkAccreditationBadgesPrint::class)->name('accreditations.print');
    Route::get('/accreditations/batch-print', \App\Livewire\Public\AccreditationBatchPrint::class)->name('accreditations.batch-print');
    Route::get('/scanner',          \App\Livewire\Admin\AdminQrScanner::class)->name('scanner');
});

// Public: Certificate Verification & Live TV Display
Route::get('/verify-certificate/{token}', CertificateVerify::class)->name('certificate.verify');
Route::get('/live-tv', LiveTvDisplay::class)->name('live-tv');

// Country Portal Routes (Delegation Heads — رئيس الوفد)
Route::prefix('country')->middleware(['auth', 'role:' . RoleEnum::COUNTRY_ADMIN->value])->name('country.')->group(function () {
    Route::get('/dashboard', CountryDashboard::class)->name('dashboard');
    Route::get('/delegation', function() { return redirect()->route('country.dashboard'); })->name('delegation');
    Route::get('/participants', function() { return redirect()->route('country.dashboard', ['filterRole' => 'PARTICIPANT']); })->name('participants');
    Route::get('/judges', function() { return redirect()->route('country.dashboard', ['filterRole' => 'JUDGE']); })->name('judges');
    Route::get('/press', function() { return redirect()->route('country.dashboard', ['filterRole' => 'PRESS']); })->name('press');
    Route::get('/supervisors', function() { return redirect()->route('country.dashboard', ['filterRole' => 'SUPERVISOR']); })->name('supervisors');
    Route::get('/vips', function() { return redirect()->route('country.dashboard', ['filterRole' => 'VIP']); })->name('vips');
    Route::get('/dietary', DietaryManager::class)->name('dietary');
    Route::get('/arrivals', \App\Livewire\Country\DelegationArrivals::class)->name('arrivals');
});

// Public: Universal PDF Streaming Route for Mobile Compatibility
Route::get('/view-pdf/{file}', function ($file) {
    $filename = basename($file);
    
    // Check in public/
    $path = public_path($filename);
    if (!file_exists($path)) {
        // Check in public/docs/
        $path = public_path('docs/' . $filename);
    }
    if (!file_exists($path)) {
        // Check in storage/app/public/
        $path = storage_path('app/public/' . $filename);
    }
    if (!file_exists($path)) {
        abort(404, 'PDF Document not found.');
    }

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . $filename . '"',
        'Cache-Control' => 'public, max-age=3600',
    ]);
})->where('file', '.*')->name('pdf.view');

// Public API: Latest Notification Endpoint for Live Toast & PWA Push Notifications
Route::get('/api/v1/notifications/latest', function (\Illuminate\Http\Request $request) {
    $lastId = (int) $request->query('last_id', 0);
    $locale = app()->getLocale();

    $notif = \App\Models\WsapNotification::where('status', 'SENT')
        ->where('id', '>', $lastId)
        ->latest('dispatched_at')
        ->first();

    if (!$notif) {
        return response()->json(['notification' => null]);
    }

    $title = match($locale) {
        'fr' => $notif->title_fr ?: $notif->title_ar,
        'en' => $notif->title_en ?: $notif->title_ar,
        default => $notif->title_ar,
    };

    $body = match($locale) {
        'fr' => $notif->body_fr ?: $notif->body_ar,
        'en' => $notif->body_en ?: $notif->body_ar,
        default => $notif->body_ar,
    };

    return response()->json([
        'notification' => [
            'id'    => $notif->id,
            'title' => $title,
            'body'  => $body,
            'type'  => $notif->type,
        ]
    ]);
});
