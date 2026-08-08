@props([
    'title' => '',
    'headers' => []
])

<div class="glass-card rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    @if($title)
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h3 class="text-sm font-black text-slate-900">{{ $title }}</h3>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-start text-xs font-medium text-slate-700">
            @if(count($headers) > 0)
                <thead class="bg-slate-100/70 text-slate-500 uppercase tracking-wider font-extrabold text-[11px] border-b border-slate-200/60">
                    <tr>
                        @foreach($headers as $header)
                            <th scope="col" class="px-6 py-3.5 text-start">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody class="divide-y divide-slate-100">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
