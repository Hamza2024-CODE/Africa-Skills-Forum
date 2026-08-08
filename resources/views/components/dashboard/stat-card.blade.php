@props([
    'title' => '',
    'value' => 0,
    'subtitle' => '',
    'color' => 'blue',
    'badge' => ''
])

@php
    $colorClasses = match($color) {
        'emerald' => 'from-emerald-50 to-teal-50 border-emerald-200 text-emerald-700 icon-bg-emerald',
        'amber' => 'from-amber-50 to-orange-50 border-amber-200 text-amber-700 icon-bg-amber',
        'purple' => 'from-purple-50 to-indigo-50 border-purple-200 text-purple-700 icon-bg-purple',
        'rose' => 'from-rose-50 to-pink-50 border-rose-200 text-rose-700 icon-bg-rose',
        default => 'from-blue-50 to-indigo-50 border-blue-200 text-blue-700 icon-bg-blue'
    };
@endphp

<div class="glass-card rounded-2xl p-5 border shadow-xs hover:shadow-md transition-all duration-300 flex flex-col justify-between space-y-4">
    <div class="flex items-center justify-between">
        <span class="text-xs font-extrabold text-slate-500 tracking-wide uppercase">{{ $title }}</span>
        @if($badge)
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black tracking-wide bg-white/80 border border-slate-200/80 text-slate-700 shadow-2xs">
                {{ $badge }}
            </span>
        @endif
    </div>

    <div class="flex items-baseline justify-between gap-2">
        <span class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">{{ number_format($value) }}</span>
        @if($subtitle)
            <span class="text-xs font-bold text-slate-400">{{ $subtitle }}</span>
        @endif
    </div>
</div>
