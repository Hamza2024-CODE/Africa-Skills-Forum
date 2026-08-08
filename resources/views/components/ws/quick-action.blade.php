@props([
    'icon',
    'label',
    'href'    => '#',
    'color'   => 'slate', // 'slate' | 'blue' | 'emerald' | 'amber' | 'rose' | 'violet'
    'disabled' => false,
])
@php
$colorMap = [
    'slate'   => 'hover:bg-slate-50  border-slate-200  text-slate-700',
    'blue'    => 'hover:bg-blue-50   border-blue-200   text-blue-700',
    'emerald' => 'hover:bg-emerald-50 border-emerald-200 text-emerald-700',
    'amber'   => 'hover:bg-amber-50  border-amber-200  text-amber-700',
    'rose'    => 'hover:bg-rose-50   border-rose-200   text-rose-700',
    'violet'  => 'hover:bg-violet-50 border-violet-200 text-violet-700',
];
$cls = $colorMap[$color] ?? $colorMap['slate'];
@endphp
<a
    href="{{ $disabled ? '#' : $href }}"
    @class([
        'flex flex-col items-center gap-2 p-4 rounded-2xl border bg-white/60 text-center transition-all duration-200 group cursor-pointer',
        $cls,
        'opacity-40 pointer-events-none' => $disabled,
    ])
>
    <span class="text-2xl group-hover:scale-110 transition-transform duration-200">{{ $icon }}</span>
    <span class="text-[11px] font-black leading-snug">{{ $label }}</span>
</a>
