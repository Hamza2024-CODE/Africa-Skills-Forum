@props([
    'icon'    => null,
    'title'   => null,
    'message' => null,
    'action'  => null,
    'actionUrl' => '#',
])
<div class="flex flex-col items-center justify-center py-16 px-8 text-center space-y-4">
    <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center">
        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
    </div>
    @if($title)
        <h3 class="text-sm font-black text-slate-700">{{ $title }}</h3>
    @endif
    @if($message)
        <p class="text-xs font-medium text-slate-400 max-w-xs leading-relaxed">{{ $message }}</p>
    @endif
    @if($action)
        <a href="{{ $actionUrl }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-blue-600 transition-colors">
            {{ $action }}
        </a>
    @endif
    {{ $slot }}
</div>
