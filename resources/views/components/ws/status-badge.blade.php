@props([
    'label',
    'variant' => 'default', // 'default' | 'success' | 'warning' | 'danger' | 'info' | 'draft'
])
@php
$variantMap = [
    'default' => 'bg-slate-100 text-slate-700',
    'success' => 'bg-emerald-100 text-emerald-800',
    'warning' => 'bg-amber-100 text-amber-800',
    'danger'  => 'bg-rose-100 text-rose-800',
    'info'    => 'bg-blue-100 text-blue-800',
    'draft'   => 'bg-slate-200 text-slate-600',
    'active'  => 'bg-emerald-500 text-white',
    'pending' => 'bg-amber-500 text-white',
    'rejected'=> 'bg-rose-500 text-white',
];
$cls = $variantMap[$variant] ?? $variantMap['default'];
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black tracking-wide {$cls}"]) }}>
    {{ $label }}
</span>
