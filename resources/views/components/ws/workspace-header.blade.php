@props([
    'title',
    'subtitle' => null,
    'role'     => null,
    'badge'    => null,
    'crumbs'   => [],
])
<div class="space-y-2 pb-6 border-b border-slate-200/80">
    @if(count($crumbs))
        <x-ws.breadcrumb :crumbs="$crumbs" class="mb-3" />
    @endif
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            @if($role)
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">{{ $role }}</span>
            @endif
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-tight">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-xs font-medium text-slate-500 mt-1 max-w-2xl">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="flex items-center gap-3 shrink-0">
            @if($badge)
                <span class="px-3 py-1.5 rounded-full text-[11px] font-black bg-slate-100 text-slate-700">{{ $badge }}</span>
            @endif
            {{ $slot }}
        </div>
    </div>
</div>
