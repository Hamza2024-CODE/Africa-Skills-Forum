<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WSAP — 404 Page Not Found</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F7FC] flex items-center justify-center min-h-screen p-4 text-[#06205C]">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 shadow-xl border border-slate-200 text-center space-y-6">
        <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 mx-auto flex items-center justify-center">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h1 class="text-4xl font-black">404</h1>
        <h2 class="text-lg font-bold">الصفحة غير موجودة — Page Not Found</h2>
        <p class="text-xs text-slate-500">العنوان المطلوب غير متوفر أو تم نقله في منصة أولمبياد المهن بالجزائر.</p>
        <div>
            <a href="/" class="px-6 py-3 rounded-xl bg-brand-500 text-white font-bold text-xs hover:bg-brand-600 transition inline-block">العودة للرئيسية</a>
        </div>
    </div>
</body>
</html>
