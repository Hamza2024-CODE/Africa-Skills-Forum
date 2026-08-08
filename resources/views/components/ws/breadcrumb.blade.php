@props([
    'crumbs' => [], // array of ['label' => '', 'url' => null]
])
@php
$isRtl = app()->getLocale() === 'ar';
$separator = $isRtl ? '←' : '→';
@endphp
<nav aria-label="Breadcrumb" class="flex items-center gap-1.5 text-xs font-medium text-slate-500 flex-wrap">
    @foreach($crumbs as $i => $crumb)
        @if($i > 0)
            <span class="text-slate-300 select-none">{{ $separator }}</span>
        @endif
        @if(!empty($crumb['url']) && $i < count($crumbs) - 1)
            <a href="{{ $crumb['url'] }}" class="hover:text-slate-900 transition-colors font-bold truncate max-w-[160px]">
                {{ $crumb['label'] }}
            </a>
        @else
            <span class="font-black text-slate-900 truncate max-w-[200px]" aria-current="page">{{ $crumb['label'] }}</span>
        @endif
    @endforeach
</nav>
