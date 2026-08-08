<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WSAP — 500 Server Error</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F7FC] flex items-center justify-center min-h-screen p-4 text-[#06205C]">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 shadow-xl border border-slate-200 text-center space-y-6">
        <div class="w-16 h-16 rounded-2xl bg-purple-50 text-purple-600 mx-auto flex items-center justify-center">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <h1 class="text-4xl font-black">500</h1>
        <h2 class="text-lg font-bold">خطأ غير متوقع في الخادم — Server Error</h2>
        <p class="text-xs text-slate-500">حدث خطأ تقني داخلي أثناء معالجة الطلب. تم تسجيل التفاصيل بنجاح في سجل الأمان والحوكمة.</p>
        <div>
            <a href="/" class="px-6 py-3 rounded-xl bg-brand-500 text-white font-bold text-xs hover:bg-brand-600 transition inline-block">العودة للرئيسية</a>
        </div>
    </div>
</body>
</html>
