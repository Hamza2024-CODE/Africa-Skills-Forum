<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" @click.outside="open = false" type="button" class="px-2.5 sm:px-3.5 py-1.5 rounded-full bg-slate-100 dark:bg-[#052D48] text-xs sm:text-sm font-bold text-[#052D48] dark:text-slate-100 hover:bg-slate-200 dark:hover:bg-[#083b5e] transition flex items-center gap-1.5 border border-slate-200 dark:border-[#24BDC3]/30 shadow-xs">
        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-[#24BDC3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 9.198 15.357 6 17.555"/></svg>
        <span class="uppercase font-mono font-black text-xs text-[#052D48] dark:text-[#24BDC3]">{{ app()->getLocale() }}</span>
        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </button>
    <div x-show="open" x-cloak x-transition class="absolute top-full {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} mt-2 w-40 rounded-2xl bg-white dark:bg-[#052D48] shadow-2xl border border-slate-200 dark:border-[#24BDC3]/30 py-2 z-50 overflow-hidden">
        <a href="{{ route('lang.switch', 'ar') }}" @click.prevent="window.location.href = '{{ route('lang.switch', 'ar') }}'" data-navigate-ignore rel="external" class="flex items-center justify-between px-4 py-2.5 text-sm font-bold transition {{ app()->getLocale() === 'ar' ? 'text-[#24BDC3] bg-teal-50 dark:bg-teal-950/40 font-black' : 'text-[#052D48] dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-[#083b5e]' }}">
            <span>العربية</span>
            <span class="text-xs text-slate-400 font-mono">AR</span>
        </a>
        <a href="{{ route('lang.switch', 'fr') }}" @click.prevent="window.location.href = '{{ route('lang.switch', 'fr') }}'" data-navigate-ignore rel="external" class="flex items-center justify-between px-4 py-2.5 text-sm font-bold transition {{ app()->getLocale() === 'fr' ? 'text-[#24BDC3] bg-teal-50 dark:bg-teal-950/40 font-black' : 'text-[#052D48] dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-[#083b5e]' }}">
            <span>Français</span>
            <span class="text-xs text-slate-400 font-mono">FR</span>
        </a>
        <a href="{{ route('lang.switch', 'en') }}" @click.prevent="window.location.href = '{{ route('lang.switch', 'en') }}'" data-navigate-ignore rel="external" class="flex items-center justify-between px-4 py-2.5 text-sm font-bold transition {{ app()->getLocale() === 'en' ? 'text-[#24BDC3] bg-teal-50 dark:bg-teal-950/40 font-black' : 'text-[#052D48] dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-[#083b5e]' }}">
            <span>English</span>
            <span class="text-xs text-slate-400 font-mono">EN</span>
        </a>
        <a href="{{ route('lang.switch', 'pt') }}" @click.prevent="window.location.href = '{{ route('lang.switch', 'pt') }}'" data-navigate-ignore rel="external" class="flex items-center justify-between px-4 py-2.5 text-sm font-bold transition {{ app()->getLocale() === 'pt' ? 'text-[#24BDC3] bg-teal-50 dark:bg-teal-950/40 font-black' : 'text-[#052D48] dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-[#083b5e]' }}">
            <span>Português</span>
            <span class="text-xs text-slate-400 font-mono">PT</span>
        </a>
    </div>
</div>
