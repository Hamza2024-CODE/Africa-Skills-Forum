@props(['items' => []])

<div x-show="mobileNavOpen" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 lg:hidden flex" x-cloak>

    <!-- Overlay backdrop -->
    <div @click="mobileNavOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

    <!-- Drawer Content Container -->
    <div class="relative w-4/5 max-w-sm bg-white dark:bg-slate-900 h-full shadow-2xl p-6 flex flex-col space-y-6 z-10 overflow-y-auto border-e border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-700 text-white font-black flex items-center justify-center text-lg shadow-sm">W</div>
                <div>
                    <h3 class="text-sm font-black text-slate-900 dark:text-white">WorldSkills Algeria</h3>
                    <p class="text-[11px] font-bold text-slate-400">WSAP Mobile Suite</p>
                </div>
            </div>
            <button @click="mobileNavOpen = false" type="button" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 touch-target">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="space-y-1.5 flex-1">
            <p class="px-2 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">
                {{ app()->getLocale() === 'fr' ? 'Navigation Mobile' : (app()->getLocale() === 'en' ? 'Mobile Navigation' : 'القائمة الرئيسية') }}
            </p>
            @foreach($items as $item)
                @php
                    $isActive = request()->routeIs($item['route']);
                @endphp
                <a href="{{ route($item['route']) }}" 
                   @click="mobileNavOpen = false"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-bold transition touch-target {{ $isActive ? 'bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-sky-300 border border-blue-200 dark:border-blue-800 shadow-xs' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <span class="w-2.5 h-2.5 rounded-full {{ $isActive ? 'bg-blue-600 dark:bg-sky-400' : 'bg-slate-300 dark:bg-slate-600' }}"></span>
                    <span class="truncate">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>

        <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-3 rounded-xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-300 border border-rose-200 dark:border-rose-800 font-bold text-xs hover:bg-rose-100 dark:hover:bg-rose-900 transition touch-target flex items-center justify-center gap-2">
                    <span>{{ app()->getLocale() === 'fr' ? 'Déconnexion' : (app()->getLocale() === 'en' ? 'Sign Out' : 'تسجيل الخروج') }}</span>
                </button>
            </form>
        </div>
    </div>
</div>
