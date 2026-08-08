<div class="space-y-5 pb-8">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 dark:text-slate-100">سجلات التدقيق والأمان الحية</h1>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">إجمالي السجلات: <span class="text-blue-600 dark:text-blue-400 font-bold">{{ number_format($totalLogs) }}</span> عملية مسجلة</p>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="بحث بالحدث، المستخدم، أو عنوان IP..."
                class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <select wire:model.live="filterEvent"
            class="px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">كل الأحداث</option>
            @foreach($events as $ev)
                <option value="{{ $ev }}">{{ $ev }}</option>
            @endforeach
        </select>
    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/60 text-[11px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <th class="px-5 py-3.5 text-start w-16">#</th>
                        <th class="px-5 py-3.5 text-start">الحدث / العملية</th>
                        <th class="px-5 py-3.5 text-start">المستخدم</th>
                        <th class="px-5 py-3.5 text-start">عنوان IP</th>
                        <th class="px-5 py-3.5 text-start">التاريخ والوقت</th>
                        <th class="px-5 py-3.5 text-end">التفاصيل</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition group">
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-400">#{{ $log->id }}</td>
                            <td class="px-5 py-3.5 font-bold text-blue-600 dark:text-blue-400">{{ $log->event }}</td>
                            <td class="px-5 py-3.5 text-slate-900 dark:text-slate-100 font-bold">{{ $log->user?->name ?? 'زائر / نظام' }}</td>
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-500">{{ $log->ip_address }}</td>
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-500">{{ $log->created_at?->format('Y-m-d H:i:s') }}</td>
                            <td class="px-5 py-3.5 text-end">
                                <button wire:click="openDrawer({{ $log->id }})" class="px-3 py-1 text-xs font-bold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 rounded-lg">عرض</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-slate-400 font-medium">لا توجد سجلات أمان مسجلة</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700">{{ $logs->links() }}</div>
        @endif
    </div>

    {{-- DETAIL DRAWER --}}
    @if($drawerOpen && $selectedLog)
        <div class="fixed inset-0 z-50 flex justify-end bg-slate-900/40 backdrop-blur-xs">
            <div class="w-full max-w-md bg-white dark:bg-slate-800 border-s border-slate-200 dark:border-slate-700 h-full p-6 overflow-y-auto space-y-6 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h2 class="text-xl font-black text-slate-900 dark:text-slate-100">تفاصيل السجل #{{ $selectedLog->id }}</h2>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="space-y-3">
                    <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-xl space-y-2 text-xs font-mono">
                        <div><span class="text-slate-400">IP:</span> {{ $selectedLog->ip_address }}</div>
                        <div><span class="text-slate-400">User Agent:</span> {{ $selectedLog->user_agent }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
