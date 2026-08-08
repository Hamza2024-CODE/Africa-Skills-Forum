@props([
    'checks' => [], // array of ['label'=>'','status'=>'ok|warn|error']
    'score'  => null,
])
@php
$statusMap = [
    'ok'    => ['dot' => 'bg-emerald-500 animate-pulse', 'text' => 'text-emerald-600', 'label' => __('Healthy')],
    'warn'  => ['dot' => 'bg-amber-400 animate-pulse',   'text' => 'text-amber-600',   'label' => __('Degraded')],
    'error' => ['dot' => 'bg-rose-500 animate-pulse',    'text' => 'text-rose-600',     'label' => __('Error')],
];
@endphp
<div {{ $attributes->merge(['class' => 'glass-card rounded-2xl p-5 border shadow-xs space-y-4']) }}>
    <div class="flex items-center justify-between">
        <span class="text-xs font-black text-slate-500 uppercase tracking-wider">{{ __('System Health') }}</span>
        @if($score)
            <span class="text-xs font-black text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full">
                {{ $score }}
            </span>
        @endif
    </div>
    <div class="space-y-2.5">
        @foreach($checks as $check)
            @php $s = $statusMap[$check['status'] ?? 'ok'] ?? $statusMap['ok']; @endphp
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full {{ $s['dot'] }}"></span>
                    <span class="text-xs font-bold text-slate-700">{{ $check['label'] }}</span>
                </div>
                <span class="text-[11px] font-black {{ $s['text'] }}">{{ $s['label'] }}</span>
            </div>
        @endforeach
    </div>
</div>
