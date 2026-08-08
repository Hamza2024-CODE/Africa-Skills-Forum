<?php
// Quick debug - accessible at /locale-debug.php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$request = \Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

$locale = app()->getLocale();
$session_locale = session('locale', 'NOT SET');
$user = auth()->user();

echo "<pre style='font-size:14px;direction:ltr;text-align:left;padding:20px'>";
echo "=== LOCALE DEBUG ===\n\n";
echo "app()->getLocale()       : " . $locale . "\n";
echo "session('locale')        : " . $session_locale . "\n";
echo "session()->getId()       : " . session()->getId() . "\n";
echo "session driver           : " . config('session.driver') . "\n";
echo "config('app.locale')     : " . config('app.locale') . "\n";
echo "User locale (DB)         : " . ($user ? ($user->locale ?? 'NULL') : 'NOT AUTH') . "\n";
echo "\n=== TEST TRANSLATION ===\n";
echo "__('الرئيسية')           : " . __('الرئيسية') . "\n";
echo "__('messages.home')      : " . __('messages.home') . "\n";
echo "\nSwitch to FR: <a href='/lang/fr?redirect=/locale-debug.php'>Click FR</a>\n";
echo "Switch to EN: <a href='/lang/en?redirect=/locale-debug.php'>Click EN</a>\n";
echo "Switch to AR: <a href='/lang/ar?redirect=/locale-debug.php'>Click AR</a>\n";
echo "</pre>";
