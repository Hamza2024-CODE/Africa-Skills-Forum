@props([
    'cols' => 4, // 2 | 3 | 4
])
@php
$gridMap = [
    2 => 'grid-cols-2',
    3 => 'grid-cols-2 sm:grid-cols-3',
    4 => 'grid-cols-2 sm:grid-cols-2 lg:grid-cols-4',
];
$grid = $gridMap[$cols] ?? $gridMap[4];
@endphp
<div {{ $attributes->merge(['class' => "grid {$grid} gap-3 sm:gap-4"]) }}>
    {{ $slot }}
</div>
