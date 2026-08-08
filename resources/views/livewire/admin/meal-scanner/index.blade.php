<div class="space-y-5 p-4 sm:p-6" dir="rtl"
     x-data="{
         cameraOpen: false,
         stream: null,
         startCamera() {
             this.cameraOpen = true;
             navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment', width: 640, height: 480 } })
                 .then(s => {
                     this.stream = s;
                     $refs.scanVideo.srcObject = s;
                 })
                 .catch(err => {
                     alert('تعذر فتح الكاميرا: ' + err.message);
                     this.cameraOpen = false;
                 });
         },
         stopCamera() {
             if (this.stream) this.stream.getTracks().forEach(t => t.stop());
             this.cameraOpen = false;
         }
     }"
     @scan-complete.window="$el.querySelector('#badge-input')?.focus()">

    {{-- ══ HEADER ══ --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-[#06205C] flex items-center justify-center shadow-md flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                          d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM6.75 6.75h.75v.75h-.75V6.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75V6.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 18.75h.75v.75h-.75v-.75zM18 13.5h.75v.75H18v-.75zM18 18.75h.75v.75H18v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-black text-[#06205C] tracking-tight">ماسح شارة المطعم</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Meal Access Scanner — WSAP V8.3</p>
            </div>
        </div>
        <a href="{{ route('admin.restaurants') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 font-bold text-xs shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            لوحة المطاعم
        </a>
    </div>

    {{-- ══ SLOT SELECTOR ══ --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 space-y-2">
        <label class="block text-xs font-black text-[#06205C] uppercase tracking-wider mb-1">
            اختر الوجبة الحالية
        </label>
        <select wire:model.live="selectedSlotId"
                class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 font-bold text-sm focus:ring-2 focus:ring-[#06205C]/30 focus:border-[#06205C] transition">
            <option value="">— اختر وجبة لليوم —</option>
            @foreach($todaySlots as $slot)
            <option value="{{ $slot->id }}">
                {{ $slot->meal_label }} — {{ $slot->restaurant?->name_ar }}
                ({{ $slot->start_time }} → {{ $slot->end_time }})
                {{ $slot->is_open ? '(مفتوحة)' : '(مغلقة)' }}
            </option>
            @endforeach
        </select>
    </div>

    @if($stats)

    {{-- ══ KPI STATS BAR ══ --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        {{-- Authorized --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 text-center group hover:border-emerald-300 hover:shadow-md transition">
            <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center mx-auto mb-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ $stats['authorized'] }}</div>
            <div class="text-[10px] font-bold text-emerald-600 mt-1 uppercase tracking-wide">مسموح</div>
        </div>
        {{-- Denied --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 text-center group hover:border-rose-300 hover:shadow-md transition">
            <div class="w-8 h-8 rounded-xl bg-rose-100 flex items-center justify-center mx-auto mb-2">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ $stats['denied'] }}</div>
            <div class="text-[10px] font-bold text-rose-600 mt-1 uppercase tracking-wide">مرفوض</div>
        </div>
        {{-- Duplicate --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 text-center group hover:border-amber-300 hover:shadow-md transition">
            <div class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center mx-auto mb-2">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ $stats['duplicate'] }}</div>
            <div class="text-[10px] font-bold text-amber-600 mt-1 uppercase tracking-wide">مكرر</div>
        </div>
        {{-- Remaining --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 text-center group hover:border-blue-300 hover:shadow-md transition">
            <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center mx-auto mb-2">
                <svg class="w-4 h-4 text-[#06205C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ $stats['remaining'] }}</div>
            <div class="text-[10px] font-bold text-[#06205C] mt-1 uppercase tracking-wide">متبقي</div>
        </div>
    </div>

    {{-- ══ CAPACITY PROGRESS ══ --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 space-y-2">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-xs font-black text-[#06205C]">{{ $stats['slot']->restaurant?->name_ar }}</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-[#06205C]/10 text-[#06205C]">
                    {{ $stats['slot']->meal_label }}
                </span>
                <span class="text-[10px] text-slate-400 font-mono">{{ $stats['slot']->start_time }} — {{ $stats['slot']->end_time }}</span>
            </div>
            <span class="text-xs font-black text-slate-700">{{ $stats['authorized'] }} / {{ $stats['capacity'] }}
                <span class="text-slate-400 font-medium">({{ $stats['pct'] }}%)</span>
            </span>
        </div>
        <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden">
            @php $bar = $stats['pct'] >= 95 ? 'bg-rose-500' : ($stats['pct'] >= 80 ? 'bg-amber-500' : 'bg-emerald-500'); @endphp
            <div class="h-full {{ $bar }} rounded-full transition-all duration-700"
                 :style="'width: ' + {{ $stats['pct'] }} + '%'"></div>
        </div>
    </div>

    {{-- ══ SCANNER ZONE ══ --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-black text-[#06205C] flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5z"/>
                </svg>
                مسح الشارة
            </h2>
            <button @click="cameraOpen ? stopCamera() : startCamera()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border text-xs font-bold transition
                           {{ '' }} border-slate-200 bg-slate-50 hover:bg-[#06205C] hover:text-white hover:border-[#06205C] text-slate-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/>
                </svg>
                <span x-text="cameraOpen ? 'إغلاق الكاميرا' : 'مسح QR بالكاميرا'"></span>
            </button>
        </div>

        {{-- QR Camera Viewfinder --}}
        <div x-show="cameraOpen" x-transition class="space-y-3">
            <div class="relative w-full max-w-sm mx-auto aspect-square rounded-2xl overflow-hidden border-2 border-[#06205C]/30 shadow-lg bg-slate-900">
                <video x-ref="scanVideo" autoplay playsinline muted class="w-full h-full object-cover"></video>
                {{-- Targeting reticle --}}
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="relative w-44 h-44">
                        {{-- Corners only --}}
                        <span class="absolute top-0 start-0 w-6 h-6 border-t-2 border-s-2 border-[#06205C] rounded-tl-lg"></span>
                        <span class="absolute top-0 end-0 w-6 h-6 border-t-2 border-e-2 border-[#06205C] rounded-tr-lg"></span>
                        <span class="absolute bottom-0 start-0 w-6 h-6 border-b-2 border-s-2 border-[#06205C] rounded-bl-lg"></span>
                        <span class="absolute bottom-0 end-0 w-6 h-6 border-b-2 border-e-2 border-[#06205C] rounded-br-lg"></span>
                        {{-- Scan line animation --}}
                        <div class="absolute inset-x-0 h-0.5 bg-[#06205C]/70"
                             style="animation: scanLine 2s ease-in-out infinite;"
                             x-data></div>
                    </div>
                </div>
                <div class="absolute bottom-3 inset-x-0 text-center">
                    <span class="inline-block px-3 py-1 bg-black/50 backdrop-blur-sm text-white text-[10px] font-bold rounded-full">
                        وجّه QR الشارة داخل الإطار
                    </span>
                </div>
            </div>
        </div>

        {{-- Manual Badge Input --}}
        <div class="flex gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 start-0 ps-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/>
                    </svg>
                </div>
                <input wire:model="badgeInput" id="badge-input" type="text"
                       placeholder="أدخل رمز الشارة يدوياً أو مسح QR..."
                       class="w-full ps-10 pe-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl text-sm font-mono placeholder-slate-400
                              focus:ring-2 focus:ring-[#06205C]/30 focus:border-[#06205C] transition"
                       wire:keydown.enter="scanBadge()"
                       autofocus>
            </div>
            <button wire:click="scanBadge()" wire:loading.attr="disabled"
                    class="px-5 py-3 rounded-xl bg-[#06205C] hover:bg-blue-900 text-white font-black text-sm transition shadow-md shadow-[#06205C]/20 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" wire:loading.class="hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4"/>
                </svg>
                <svg class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24" wire:loading.class.remove="hidden">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
                مسح
            </button>
        </div>
    </div>

    {{-- ══ SCAN RESULT ══ --}}
    @if($lastResult)
    <div class="rounded-2xl border-2 shadow-md overflow-hidden
        {{ $alertClass === 'authorized' ? 'border-emerald-400 bg-emerald-50' :
           ($alertClass === 'duplicate'  ? 'border-amber-400 bg-amber-50' :
                                           'border-rose-400 bg-rose-50') }}">

        {{-- Colored top bar --}}
        <div class="px-5 py-3 flex items-center gap-3
             {{ $alertClass === 'authorized' ? 'bg-emerald-500' : ($alertClass === 'duplicate' ? 'bg-amber-500' : 'bg-rose-500') }}">
            <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center">
                @if($alertClass === 'authorized')
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @elseif($alertClass === 'duplicate')
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @endif
            </div>
            <div class="flex-1">
                <div class="font-black text-white text-sm">
                    {{ $alertClass === 'authorized' ? 'مسموح بالدخول' : ($alertClass === 'duplicate' ? 'وجبة مستهلكة مسبقاً' : 'مرفوض') }}
                </div>
                <div class="text-white/80 text-[10px] font-medium">{{ now()->format('H:i:s') }}</div>
            </div>
            @if($alertClass === 'authorized')
            <div class="text-2xl font-black text-white tracking-widest">BON APPÉTIT</div>
            @endif
        </div>

        {{-- Result body --}}
        <div class="px-5 py-4 space-y-3">
            @if($lastResult['name'] !== 'غير معروف')
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#06205C] flex items-center justify-center text-white font-black text-lg shadow-sm">
                    {{ mb_strtoupper(mb_substr($lastResult['name'], 0, 1, 'UTF-8'), 'UTF-8') }}
                </div>
                <div>
                    <div class="font-black text-slate-900 text-base leading-tight">{{ $lastResult['name'] }}</div>
                    <div class="text-xs text-slate-500 font-medium">{{ $lastResult['country'] }}</div>
                </div>
            </div>
            @endif

            <div class="flex flex-wrap gap-2 pt-1">
                @if($lastResult['meal'])
                <span class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 shadow-sm">
                    {{ $lastResult['meal'] }}
                </span>
                @endif
                @if($lastResult['restaurant'])
                <span class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 shadow-sm">
                    {{ $lastResult['restaurant'] }}
                </span>
                @endif
            </div>

            @if($alertClass === 'denied' || $alertClass === 'duplicate')
            <div class="p-3 rounded-xl bg-white/60 border border-current/20 text-sm font-bold
                {{ $alertClass === 'denied' ? 'text-rose-700' : 'text-amber-700' }}">
                {{ $lastResult['message'] }}
            </div>
            @endif
        </div>
    </div>
    @endif

    @else
    {{-- No slot selected --}}
    <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-14 text-center space-y-3">
        <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto">
            <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                      d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016 2.993 2.993 0 002.25-1.016 3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
            </svg>
        </div>
        <p class="font-black text-slate-600 text-sm">اختر وجبة من القائمة أعلاه لبدء المسح</p>
        @if($todaySlots->isEmpty())
        <p class="text-rose-500 text-xs font-medium">لا توجد خانات وجبات لليوم — أضف خانات من لوحة إدارة المطاعم.</p>
        @endif
    </div>
    @endif

</div>

{{-- Scan line CSS --}}
<style>
@keyframes scanLine {
    0%   { top: 0; opacity: 1; }
    50%  { top: calc(100% - 2px); opacity: 0.7; }
    100% { top: 0; opacity: 1; }
}
</style>
