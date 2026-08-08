@props([
    'title' => '',
    'subtitle' => ''
])

<div class="glass-card rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm sm:text-base font-black text-slate-900">{{ $title }}</h3>
            @if($subtitle)
                <p class="text-xs text-slate-400 font-semibold mt-0.5">{{ $subtitle }}</p>
            @endif
        </div>
        <span class="w-2.5 h-2.5 rounded-full bg-brand-500 animate-pulse"></span>
    </div>

    <!-- Chart Canvas / Visual Bars Slot -->
    <div class="pt-2">
        {{ $slot }}
    </div>
</div>
