<div class="w-screen h-screen bg-slate-950 text-white p-6 font-sans dir-rtl select-none flex flex-col justify-between" dir="rtl">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Top Header -->
    <header class="flex items-center justify-between border-b border-slate-800 pb-4">
        <div class="flex items-center space-x-4 space-x-reverse">
            <div class="w-12 h-12 rounded-2xl bg-sky-600/30 border border-sky-400/50 flex items-center justify-center text-sky-400">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
            </div>
            <div>
                <h1 class="text-xl font-black tracking-wide text-white">القرية الأورومتوسطية بوهران — شاشة الاستعلامات الكبرى للمداخل</h1>
                <p class="text-xs text-sky-400 font-semibold">WorldSkills Algeria 2026 — Real Map Interactive Kiosk Mode (35.747182, -0.542754)</p>
            </div>
        </div>

        <div class="px-4 py-2 rounded-2xl bg-sky-950/60 border border-sky-800 text-sky-300 text-xs font-black flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
            الموقع الحالي: المدخل الرئيسي
        </div>
    </header>

    <!-- Kiosk Content: Map + Grid Side by Side -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 my-4 flex-1">
        <!-- Leaflet Real Map Viewport Container -->
        <div class="lg:col-span-2 bg-slate-900 rounded-3xl border border-slate-800 overflow-hidden relative shadow-2xl">
            <div wire:ignore id="kiosk-leaflet-map" data-pois='@json($pois)' class="w-full h-full"></div>
        </div>

        <!-- POI Info Grid Sidebar -->
        <div class="space-y-4 overflow-y-auto max-h-[calc(100vh-180px)] pr-1">
            @foreach($pois as $poi)
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-4 shadow-xl flex flex-col justify-between space-y-3 hover:border-sky-500 transition">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-sky-500/20 border border-sky-400/40 flex items-center justify-center text-sky-400">
                            {!! $poi['svg_raw'] ?? '' !!}
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                            {{ $poi['status_label_ar'] ?? 'متاح' }}
                        </span>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-white">{{ $poi['title_ar'] }}</h3>
                        <p class="text-[10px] text-slate-400">{{ $poi['title_en'] }}</p>
                    </div>

                    <div class="pt-2 border-t border-slate-800/80 flex items-center justify-between text-[11px] text-slate-300">
                        <span>السعة: {{ $poi['occupancy_count'] ?? 0 }} / {{ $poi['capacity'] ?? 300 }}</span>
                        <span class="font-mono text-sky-400 font-bold">{{ $poi['occupancy_pct'] ?? 0 }}%</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Footer Banner -->
    <footer class="border-t border-slate-800 pt-3 flex items-center justify-between text-xs text-slate-400">
        <span>المس بالشاشة للتنقل والبحث في الأقسام</span>
        <span>WorldSkills Algeria — WSAP V9.0 Kiosk Real Map System</span>
    </footer>

    <!-- Leaflet.js Engine -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('kiosk-leaflet-map');
            if (!container) return;

            let poisData = [];
            try {
                poisData = JSON.parse(container.dataset.pois || '[]');
            } catch (e) {
                poisData = [];
            }

            const map = L.map('kiosk-leaflet-map', {
                center: [35.747182, -0.542754],
                zoom: 16,
                zoomControl: false
            });

            const googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: 'Google Maps Hybrid | Mediterranean Village Oran'
            });

            googleHybrid.addTo(map);

            poisData.forEach(poi => {
                const lat = poi.lat || (35.747182 - (poi.pos_z / 110940.0));
                const lng = poi.lng || (-0.542754 + (poi.pos_x / 90280.0));

                const html = `
                    <div class="wsap-leaflet-pin group relative cursor-pointer">
                        <div class="w-10 h-10 rounded-2xl bg-slate-900 border-2 border-sky-400 shadow-xl flex items-center justify-center text-sky-400">
                            ${poi.svg_raw || ''}
                        </div>
                        <div class="absolute bottom-full mb-1 right-1/2 translate-x-1/2 whitespace-nowrap bg-slate-950 text-white text-[11px] font-bold px-2.5 py-1 rounded-lg shadow-lg border border-slate-700">
                            ${poi.title_ar}
                        </div>
                    </div>
                `;

                const customIcon = L.divIcon({
                    html: html,
                    className: 'wsap-poi-div-icon',
                    iconSize: [40, 40],
                    iconAnchor: [20, 20]
                });

                L.marker([lat, lng], { icon: customIcon }).addTo(map);
            });
        });
    </script>

    <style>
        .wsap-poi-div-icon {
            background: transparent !important;
            border: none !important;
        }
    </style>
</div>
