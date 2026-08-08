@props([
    'value',            // 0-100 integer
    'label' => null,
    'sublabel' => null,
    'color' => 'brand', // 'brand' | 'emerald' | 'amber' | 'rose'
])
@php
$pct = max(0, min(100, (int)$value));
$colorMap = [
    'brand'   => 'bg-blue-500',
    'emerald' => 'bg-emerald-500',
    'amber'   => 'bg-amber-400',
    'rose'    => 'bg-rose-500',
    'violet'  => 'bg-violet-500',
];
$bar = $colorMap[$color] ?? $colorMap['brand'];
@endphp
<div {{ $attributes->merge(['class' => 'glass-card rounded-2xl p-5 border shadow-xs space-y-3']) }}>
    @if($label)
        <div class="flex items-center justify-between">
            <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wide">{{ $label }}</span>
            <span class="text-sm font-black text-slate-900 tabular-nums">{{ $pct }}%</span>
        </div>
    @endif

    <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
        <div class="h-full rounded-full transition-all duration-700 {{ $bar }}" style="width: {{ $pct }}%"></div>
    </div>

    @if($sublabel)
        <p class="text-[11px] font-medium text-slate-400">{{ $sublabel }}</p>
    @endif

    {{ $slot }}
</div>
