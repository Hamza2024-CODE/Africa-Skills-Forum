@props([
    'value',
    'label',
    'sublabel' => null,
    'icon' => null,
    'trend' => null,        // 'up' | 'down' | 'neutral'
    'trendValue' => null,
    'color' => 'brand',     // 'brand' | 'emerald' | 'amber' | 'rose' | 'violet'
    'size' => 'md',         // 'sm' | 'md' | 'lg'
])

@php
$colorMap = [
    'brand'   => ['bg' => 'bg-blue-50',   'text' => 'text-blue-600',   'border' => 'border-blue-100',  'badge' => 'bg-blue-100 text-blue-700'],
    'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-100', 'badge' => 'bg-emerald-100 text-emerald-700'],
    'amber'   => ['bg' => 'bg-amber-50',   'text' => 'text-amber-600',   'border' => 'border-amber-100',  'badge' => 'bg-amber-100 text-amber-700'],
    'rose'    => ['bg' => 'bg-rose-50',    'text' => 'text-rose-600',    'border' => 'border-rose-100',   'badge' => 'bg-rose-100 text-rose-700'],
    'violet'  => ['bg' => 'bg-violet-50',  'text' => 'text-violet-600',  'border' => 'border-violet-100', 'badge' => 'bg-violet-100 text-violet-700'],
    'slate'   => ['bg' => 'bg-slate-50',   'text' => 'text-slate-600',   'border' => 'border-slate-100',  'badge' => 'bg-slate-100 text-slate-700'],
];
$c = $colorMap[$color] ?? $colorMap['brand'];

$sizeMap = [
    'sm' => 'p-4',
    'md' => 'p-5',
    'lg' => 'p-6',
];
$p = $sizeMap[$size] ?? $sizeMap['md'];

$trendClass = match($trend) {
    'up'   => 'text-emerald-600',
    'down' => 'text-rose-600',
    default => 'text-slate-500',
};
$trendIcon = match($trend) {
    'up'   => '↑',
    'down' => '↓',
    default => '→',
};
@endphp

<div {{ $attributes->merge(['class' => "glass-card rounded-2xl {$p} border shadow-xs hover:shadow-md transition-all duration-300 flex flex-col justify-between space-y-4 group"]) }}>
    {{-- Header --}}
    <div class="flex items-start justify-between gap-3">
        <span class="text-xs font-extrabold text-slate-500 tracking-wide uppercase leading-tight">{{ $label }}</span>
        @if($icon || $sublabel)
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black tracking-wide {{ $c['badge'] }} shadow-2xs shrink-0">
                {{ $icon ?? $sublabel }}
            </span>
        @endif
    </div>

    {{-- Value --}}
    <div class="flex items-baseline justify-between gap-2">
        <span class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight tabular-nums">{{ $value }}</span>
        @if($trend && $trendValue)
            <span class="text-xs font-black {{ $trendClass }} flex items-center gap-0.5">
                {{ $trendIcon }} {{ $trendValue }}
            </span>
        @endif
    </div>

    {{-- Optional slot for extra content --}}
    @if($slot->isNotEmpty())
        <div class="pt-2 border-t border-slate-100">
            {{ $slot }}
        </div>
    @endif
</div>
