@props([
    'title',
    'subtitle' => null,
    'badge'    => null,
    'badgeColor' => 'slate', // 'slate' | 'emerald' | 'amber' | 'rose' | 'blue' | 'violet'
])

@php
$badgeColors = [
    'slate'   => 'bg-slate-100 text-slate-700',
    'emerald' => 'bg-emerald-100 text-emerald-700',
    'amber'   => 'bg-amber-100 text-amber-700',
    'rose'    => 'bg-rose-100 text-rose-700',
    'blue'    => 'bg-blue-100 text-blue-700',
    'violet'  => 'bg-violet-100 text-violet-700',
];
$bc = $badgeColors[$badgeColor] ?? $badgeColors['slate'];
@endphp

<div class="flex items-start justify-between gap-4 pb-4 border-b border-slate-100">
    <div class="min-w-0">
        <h2 class="text-base font-black text-slate-900 tracking-tight truncate">{{ $title }}</h2>
        @if($subtitle)
            <p class="text-xs font-medium text-slate-500 mt-0.5">{{ $subtitle }}</p>
        @endif
    </div>
    @if($badge)
        <span class="px-2.5 py-1 rounded-full text-[10px] font-black tracking-wide {{ $bc }} shrink-0">{{ $badge }}</span>
    @endif
    @if($slot->isNotEmpty())
        <div class="shrink-0">{{ $slot }}</div>
    @endif
</div>
