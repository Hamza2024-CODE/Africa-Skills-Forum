<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WSAP — 403 Access Denied</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F7FC] flex items-center justify-center min-h-screen p-4 text-[#06205C]">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 shadow-xl border border-slate-200 text-center space-y-6">
        <div class="w-16 h-16 rounded-2xl bg-red-50 text-red-600 mx-auto flex items-center justify-center">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <h1 class="text-4xl font-black">403</h1>
        <h2 class="text-lg font-bold">غير مصرح بالوصول — Access Denied</h2>
        <p class="text-xs text-slate-500">ليس لديك الصلاحيات الكافية لعرض هذه الصفحة أو تنفيذ الإجراء المطلوب وفق سياسات الأمان والحوكمة.</p>
        <div>
            <a href="/" class="px-6 py-3 rounded-xl bg-brand-500 text-white font-bold text-xs hover:bg-brand-600 transition inline-block">العودة للرئيسية</a>
        </div>
    </div>
</body>
</html>
