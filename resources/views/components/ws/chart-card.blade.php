@props([
    'title' => null,
    'subtitle' => null,
])
<div {{ $attributes->merge(['class' => 'glass-card rounded-2xl border shadow-xs overflow-hidden']) }}>
    @if($title)
        <div class="px-5 py-3.5 border-b flex items-center justify-between" style="border-color:var(--ws-border)">
            <div>
                <h3 class="text-sm font-black" style="color:var(--ws-text)">{{ $title }}</h3>
                @if($subtitle)
                    <p class="text-[11px] font-medium" style="color:var(--ws-muted)">{{ $subtitle }}</p>
                @endif
            </div>
            {{ $slot->hasSlot('actions') ? $actions : '' }}
        </div>
    @endif
    <div class="p-5">
        {{ $slot }}
    </div>
</div>
