@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<div class="max-w-4xl mx-auto space-y-6 pb-12"
     x-data="{
         cameraOpen: false,
         html5Qrcode: null,
         mediaStream: null,
         isScanning: false,
         errorMessage: null,

         playBeep() {
             try {
                 const ctx = new (window.AudioContext || window.webkitAudioContext)();
                 const osc = ctx.createOscillator();
                 const gain = ctx.createGain();
                 osc.type = 'sine';
                 osc.frequency.setValueAtTime(880, ctx.currentTime);
                 gain.gain.setValueAtTime(0.3, ctx.currentTime);
                 gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.25);
                 osc.connect(gain);
                 gain.connect(ctx.destination);
                 osc.start();
                 osc.stop(ctx.currentTime + 0.25);
                 if (navigator.vibrate) navigator.vibrate([100, 50, 100]);
             } catch (e) {}
         },

         async startCamera() {
             this.errorMessage = null;
             this.cameraOpen = true;

             await this.$nextTick();

             try {
                 if (typeof Html5Qrcode !== 'undefined') {
                     if (this.html5Qrcode) {
                         try { await this.html5Qrcode.stop(); } catch(e) {}
                     }
                     this.html5Qrcode = new Html5Qrcode('qr-reader');
                     await this.html5Qrcode.start(
                         { facingMode: 'environment' },
                         { fps: 15, qrbox: { width: 250, height: 250 } },
                         (decodedText) => {
                             this.playBeep();
                             this.stopCamera();
                             window.location.href = '{{ url('/panel/scanner') }}?q=' + encodeURIComponent(decodedText);
                         },
                         (errorMessage) => {}
                     );
                     this.isScanning = true;
                     return;
                 }
             } catch (err) {
                 console.error('Html5Qrcode error:', err);
                 try {
                     if (typeof Html5QrcodeScanner !== 'undefined') {
                         const html5QrcodeScanner = new Html5QrcodeScanner('qr-reader', { fps: 10, qrbox: 250 }, false);
                         html5QrcodeScanner.render((decodedText) => {
                             this.playBeep();
                             window.location.href = '{{ url('/panel/scanner') }}?q=' + encodeURIComponent(decodedText);
                         });
                         this.isScanning = true;
                         return;
                     }
                 } catch(e2) {}
             }

             this.errorMessage = '{{ $t('تعذر فتح الكاميرا: يرجى السماح بصلاحيات الكاميرا في المتصفح.', 'Impossible d\'ouvrir la caméra.', 'Unable to open camera.') }}';
         },

         stopCamera() {
             if (this.html5Qrcode && this.isScanning) {
                 try { this.html5Qrcode.stop(); } catch (e) {}
             }
             if (this.mediaStream) {
                 try { this.mediaStream.getTracks().forEach(t => t.stop()); } catch (e) {}
                 this.mediaStream = null;
             }
             this.isScanning = false;
             this.cameraOpen = false;
         },

         scanFile(event) {
             const file = event.target.files[0];
             if (!file) return;

             if (typeof Html5Qrcode !== 'undefined') {
                 const scanner = new Html5Qrcode('qr-reader');
                 scanner.scanFile(file, true)
                     .then(text => {
                         this.playBeep();
                         try { $wire.scan(text); } catch(e) {}
                         window.location.href = '{{ url('/panel/scanner') }}?q=' + encodeURIComponent(text);
                     })
                     .catch(err => {
                         alert('{{ $t('لم يتم العثور على كود QR واضح في الصورة.', 'Aucun code QR détecté.', 'No QR code detected.') }}');
                     });
             }
         }
     }">

    <!-- HEADER TITLE BANNER -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-md flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#06205C] text-amber-400 flex items-center justify-center font-black text-xl shadow-lg shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-[#06205C] dark:text-white">
                    {{ $t('الماسح الأمني الموحد لشارات الاعتماد', 'Scanner QR Sécurisé D\'Accréditation', 'Security Accreditation QR Scanner') }}
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                    {{ $t('نظام الفحص الميداني المباشر للشارات والهويات ورؤساء الوفود', 'Vérification instantanée des badges et accréditations', 'Instant field verification for badges and delegation members') }}
                </p>
            </div>
        </div>
        <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300 text-xs font-black border border-emerald-300">
            WSAP SECURITY LIVE
        </span>
    </div>

    <!-- SCAN CONTROL BOX -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-md space-y-4">
        <div class="flex items-center justify-between flex-wrap gap-2">
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                {{ $t('افحص الشارة بالكاميرا أو ادخل الرمز يدوياً *', 'Scannez le QR via la caméra ou saisissez le code *', 'Scan QR via camera or enter code manually *') }}
            </label>
            <div class="flex items-center gap-2 flex-wrap">
                <button type="button" @click="cameraOpen ? stopCamera() : startCamera()"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border text-xs font-black transition shadow-xs bg-slate-50 hover:bg-[#06205C] hover:text-white border-slate-200 text-slate-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/></svg>
                    <span x-text="cameraOpen ? '{{ $t('إغلاق الكاميرا', 'Fermer Caméra', 'Close Camera') }}' : '{{ $t('فتح الكاميرا لمسح الـ QR', 'Ouvrir Caméra QR', 'Open QR Camera') }}'"></span>
                </button>

                <label class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border text-xs font-black transition shadow-xs bg-slate-50 hover:bg-[#06205C] hover:text-white border-slate-200 text-slate-700 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ $t('رفع صورة QR', 'Uploader QR', 'Upload QR Image') }}</span>
                    <input type="file" accept="image/*" @change="scanFile($event)" class="hidden">
                </label>
            </div>
        </div>

        <!-- CAMERA FEED -->
        <div x-show="cameraOpen" class="space-y-3 pt-2">
            <div class="relative w-full max-w-sm mx-auto rounded-3xl overflow-hidden border-2 border-[#06205C]/30 shadow-xl bg-slate-950 min-h-[300px] flex items-center justify-center">
                <div id="qr-reader" class="w-full min-h-[300px] relative z-10"></div>
                <div x-show="isScanning" class="absolute inset-x-0 top-1/2 h-0.5 bg-emerald-400 shadow-[0_0_15px_#10b981] animate-pulse pointer-events-none z-20"></div>
            </div>
        </div>

        <!-- MANUAL INPUT FORM -->
        <form method="GET" action="{{ url('/panel/scanner') }}" class="space-y-3">
            <div class="flex gap-2">
                <input type="text" name="q" wire:model.live.debounce.300ms="query" value="{{ $query ?? '' }}" autofocus
                    placeholder="{{ $t('أدخل UUID الشارة، البريد الإلكتروني، أو كود المستخدم...', 'Saisissez le code UUID ou ID...', 'Enter Badge UUID, Email or User Code...') }}"
                    class="flex-1 px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-sm font-bold bg-slate-50 dark:bg-slate-900 dark:text-slate-100 focus:bg-white transition">
                <button type="submit" class="px-6 py-3 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs transition shadow-md">
                    {{ $t('فحص وتفكيك الـ QR', 'Vérifier & Analyser', 'Verify & Scan QR') }}
                </button>
            </div>
        </form>

        <!-- QUICK TEST DELEGATION BUTTONS -->
        <div class="pt-2 flex flex-wrap items-center gap-1.5 border-t border-slate-100 dark:border-slate-700/60">
            <span class="text-[11px] font-bold text-slate-400">اختبار الفحص السريع:</span>
            <a href="{{ url('/panel/scanner') }}?q=USR-00103" class="px-2.5 py-1 rounded-xl bg-blue-50 text-blue-900 hover:bg-[#06205C] hover:text-white text-[11px] font-black transition border border-blue-200">🇲🇷 موريتانيا (103)</a>
            <a href="{{ url('/panel/scanner') }}?q=USR-00104" class="px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-900 hover:bg-[#06205C] hover:text-white text-[11px] font-black transition border border-emerald-200">🇲🇿 موزمبيق (104)</a>
            <a href="{{ url('/panel/scanner') }}?q=USR-00105" class="px-2.5 py-1 rounded-xl bg-purple-50 text-purple-900 hover:bg-[#06205C] hover:text-white text-[11px] font-black transition border border-purple-200">🇳🇦 ناميبيا (105)</a>
            <a href="{{ url('/panel/scanner') }}?q=USR-00106" class="px-2.5 py-1 rounded-xl bg-amber-50 text-amber-900 hover:bg-[#06205C] hover:text-white text-[11px] font-black transition border border-amber-200">🇳🇬 نيجيريا (106)</a>
            <a href="{{ url('/panel/scanner') }}?q=USR-00098" class="px-2.5 py-1 rounded-xl bg-rose-50 text-rose-900 hover:bg-[#06205C] hover:text-white text-[11px] font-black transition border border-rose-200">🇲🇱 مالي (98)</a>
        </div>
    </div>

    <!-- ACCREDITED USER INFORMATION DOSSIER CARD -->
    @if($scanResult)
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-xl overflow-hidden space-y-0">
        
        <!-- DECISION BANNER HEADER -->
        <div class="bg-emerald-600 p-5 text-white flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center font-black text-xl text-white shrink-0">
                    ✓
                </div>
                <div>
                    <h2 class="text-xl font-black">{{ $scanResult['decision_text_ar'] }}</h2>
                    <p class="text-xs text-emerald-100 font-medium">كود الشارة التوثيقي: {{ $scanResult['clean_code'] }}</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-black font-mono border bg-white/20 text-white">
                STATUS: {{ $scanResult['badge_status'] }}
            </span>
        </div>

        <!-- PERSON MAIN HEADER -->
        <div class="bg-gradient-to-l from-[#06205C] to-[#0A3580] p-6 text-white flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 rounded-2xl border-2 border-white/30 overflow-hidden shrink-0 shadow-lg bg-white/10">
                    <img src="{{ $scanResult['avatar_url'] }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="text-xl font-black text-white">{{ $scanResult['full_name'] }}</h3>
                    <p class="text-blue-200 text-xs font-medium">{{ $scanResult['email'] }}</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="px-3 py-1 rounded-full text-[11px] font-black bg-amber-400 text-slate-900 uppercase">
                            {{ $scanResult['role'] }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-[11px] font-black bg-emerald-400/20 text-emerald-300 border border-emerald-400/40">
                            {{ $scanResult['country_flag'] }} {{ $scanResult['country_name'] }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="text-end text-xs space-y-1 font-mono text-blue-200">
                <div>UUID: {{ substr($scanResult['badge_uuid'], 0, 18) }}...</div>
                <div class="text-emerald-300 font-bold">تاريخ الفحص: {{ $scanResult['scanned_at'] }}</div>
            </div>
        </div>

        <!-- FULL DOSSIER GRID DETAILS -->
        <div class="p-6 space-y-6 text-xs">
            
            <!-- ROW 1: PERSONAL & IDENTITY -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="bg-blue-50 dark:bg-blue-950/30 p-4 rounded-2xl border border-blue-200/60 space-y-1">
                    <span class="text-blue-600 font-black block text-[10px] uppercase">الدولة / الوفد</span>
                    <span class="font-black text-[#06205C] dark:text-blue-200 text-sm block">{{ $scanResult['country_flag'] }} {{ $scanResult['country_name'] }}</span>
                </div>

                <div class="bg-amber-50 dark:bg-amber-950/30 p-4 rounded-2xl border border-amber-200/60 space-y-1">
                    <span class="text-amber-600 font-black block text-[10px] uppercase">التخصص / المهنة</span>
                    <span class="font-black text-slate-900 dark:text-slate-100 text-xs block">{{ $scanResult['skill_name'] }}</span>
                </div>

                <div class="bg-purple-50 dark:bg-purple-950/30 p-4 rounded-2xl border border-purple-200/60 space-y-1">
                    <span class="text-purple-600 font-black block text-[10px] uppercase">وثائق الهوية</span>
                    <span class="font-mono font-bold text-slate-900 dark:text-slate-100 block">جواز: {{ $scanResult['passport_number'] }}</span>
                    <span class="font-mono text-slate-500 text-[10px] block">NIN: {{ $scanResult['nin_number'] }}</span>
                </div>

                <div class="bg-teal-50 dark:bg-teal-950/30 p-4 rounded-2xl border border-teal-200/60 space-y-1">
                    <span class="text-teal-600 font-black block text-[10px] uppercase">التواصل والاتصال</span>
                    <span class="font-bold text-slate-900 dark:text-slate-100 block">{{ $scanResult['phone'] }}</span>
                    <span class="text-slate-500 block truncate text-[10px]">{{ $scanResult['email'] }}</span>
                </div>
            </div>

            <!-- ROW 2: ACCOMMODATION, FLIGHTS, SIZES -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="bg-indigo-50 dark:bg-indigo-950/30 p-4 rounded-2xl border border-indigo-200/60 space-y-1">
                    <span class="text-indigo-600 font-black block text-[10px] uppercase">الغرفة والإقامة</span>
                    <span class="font-black text-indigo-900 dark:text-indigo-200 text-xs block">{{ $scanResult['hotel_name'] }}</span>
                    <span class="font-bold text-emerald-600 block text-[11px]">{{ $scanResult['room_number'] }}</span>
                </div>

                <div class="bg-sky-50 dark:bg-sky-950/30 p-4 rounded-2xl border border-sky-200/60 space-y-1">
                    <span class="text-sky-600 font-black block text-[10px] uppercase">رحلات الطيران</span>
                    <span class="font-bold text-slate-900 dark:text-slate-100 block text-[11px]">الوصول: {{ $scanResult['arrival_flight'] }}</span>
                    <span class="font-bold text-slate-900 dark:text-slate-100 block text-[11px]">المغادرة: {{ $scanResult['departure_flight'] }}</span>
                </div>

                <div class="bg-rose-50 dark:bg-rose-950/30 p-4 rounded-2xl border border-rose-200/60 space-y-1">
                    <span class="text-rose-600 font-black block text-[10px] uppercase">القياسات والبدلة</span>
                    <span class="font-bold text-slate-900 dark:text-slate-100 block text-[11px]">مقاس البدلة: <b>{{ $scanResult['suit_size'] }}</b></span>
                    <span class="font-bold text-slate-900 dark:text-slate-100 block text-[11px]">مقاس الحذاء: <b>{{ $scanResult['shoe_size'] }}</b></span>
                </div>

                <div class="bg-slate-50 dark:bg-slate-900/40 p-4 rounded-2xl border border-slate-200/60 space-y-1">
                    <span class="text-slate-500 font-black block text-[10px] uppercase">تصاريح الدخول للمناطق</span>
                    <span class="font-bold text-emerald-700 block text-[11px]">✓ VIP Hall & Lounge</span>
                    <span class="font-bold text-emerald-700 block text-[11px]">✓ Main Forum & Workshops</span>
                </div>
            </div>

        </div>

        <!-- FOOTER BAR -->
        <div class="bg-slate-50 dark:bg-slate-900/60 px-6 py-3 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between text-[11px] text-slate-500 font-mono">
            <span>TOKEN: {{ $scanResult['clean_code'] }}</span>
            <span>WSAP-SECURITY-VERIFIED-100%</span>
        </div>
    </div>
    @endif

</div>