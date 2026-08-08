<div class="w-full font-sans dir-rtl space-y-6" dir="rtl" wire:poll.5s>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Light Blue & White Top Navigation Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-5 rounded-3xl border border-slate-200/90 shadow-xl">
        <div class="flex items-center space-x-4 space-x-reverse">
            <div class="w-12 h-12 rounded-2xl bg-[#EEF6FF] border border-[#0066FF]/30 flex items-center justify-center text-[#0066FF] shadow-sm">
                <svg class="w-7 h-7 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            </div>
            <div>
                <h1 class="text-lg font-black text-[#06205C] tracking-wide">القرية الأورومتوسطية بوهران — الخريطة الجغرافية بالستلايت</h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs text-[#0066FF] font-bold">Mediterranean Village Oran (35.7471827, -0.5351771)</span>
                </div>
            </div>
        </div>

        <!-- Admin Direct Link -->
        <div class="flex items-center gap-3">
            @auth
                @if(auth()->user()->hasRole(\App\Enums\RoleEnum::SUPER_ADMIN->value))
                    <a href="{{ route('admin.venue-map') }}" class="px-4 py-2 rounded-2xl text-xs font-black bg-[#0066FF] text-white shadow-md shadow-blue-500/20 hover:bg-blue-700 transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        لوحة الإدارة والبناء 3D
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <!-- Main Clean Grid: Sidebar Panel + Map Viewport -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <!-- Side POIs List Panel -->
        <div class="space-y-4 lg:col-span-1">
            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-xl space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-black text-[#06205C] tracking-wide">قائمة معالم القرية</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-blue-50 text-[#0066FF] border border-blue-200">
                        {{ count($pois) }} معالم
                    </span>
                </div>

                <div class="space-y-2.5 max-h-[580px] overflow-y-auto pr-1">
                    @foreach($pois as $poi)
                        @php $poiId = (int) ($poi['poi_id'] ?? 0); @endphp
                        <div data-poi-id="{{ $poiId }}" onclick="openPoiCardDetails(this.dataset.poiId)" class="p-3.5 bg-slate-50 hover:bg-blue-50 rounded-2xl border border-slate-200 hover:border-[#0066FF] transition-all cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3 space-x-reverse">
                                    <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-[#0066FF] shadow-sm">
                                        {!! $poi['svg_raw'] ?? '' !!}
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-black text-[#06205C]">{{ $poi['title_ar'] }}</h4>
                                        <p class="text-[10px] text-slate-400 font-bold">{{ $poi['building_code'] ?? 'القرية الأورومتوسطية' }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    {{ $poi['status_label_ar'] ?? 'مفتوح' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Main Map Container Box (Explicit 650px height) -->
        <div class="lg:col-span-3 bg-white rounded-3xl border border-slate-200/90 h-[650px] min-h-[650px] relative overflow-hidden shadow-2xl">
            
            <!-- 1. Leaflet Interactive Satellite Map Container -->
            <div id="leaflet-tile-container" class="w-full h-full relative transition-all duration-500">
                <div wire:ignore id="wsap-real-leaflet-map" data-pois='@json($pois)' data-boundary='@json($customBoundary ?? null)' style="width: 100%; height: 650px; min-height: 650px;"></div>
            </div>

            <!-- 2. Google Maps Direct 3D Street View / Photosphere Embed Container -->
            <div id="streetview-container" class="hidden w-full h-full relative">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3330.82498725838!2d-0.5373720234720935!3d35.74718267986064!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd7e7d3c8df9e8f5%3A0x1823ea0b526356b2!2sMediterranean%20Village%20Oran!5e1!3m2!1sfr!2sdz!4v1785930530410!5m2!1sfr!2sdz" width="100%" height="100%" style="border:0; min-height: 650px;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>

            <!-- 3. Google Maps Direct Satellite Embed Container -->
            <div id="google-iframe-container" class="hidden w-full h-full relative">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3330.82498725838!2d-0.5373720234720935!3d35.74718267986064!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd7e7d3c8df9e8f5%3A0x1823ea0b526356b2!2sMediterranean%20Village%20Oran!5e1!3m2!1sfr!2sdz!4v1785930530410!5m2!1sfr!2sdz" width="100%" height="100%" style="border:0; min-height: 650px;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>

            <!-- Light Blue & White POI Info Card Modal -->
            <div id="poi-info-card" class="hidden absolute bottom-6 right-6 z-[1001] w-96 bg-white/95 backdrop-blur-xl border border-sky-100 rounded-3xl p-6 shadow-2xl transition-all transform duration-300">
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <div id="card-icon-wrapper" class="w-12 h-12 rounded-2xl bg-[#EEF6FF] border border-[#0066FF]/30 flex items-center justify-center text-[#0066FF] shadow-sm">
                            <div id="card-icon-svg"></div>
                        </div>
                        <div>
                            <h3 id="card-title" class="text-base font-extrabold text-[#06205C]"></h3>
                            <p id="card-subtitle" class="text-xs font-bold text-slate-500"></p>
                        </div>
                    </div>
                    <button onclick="closePoiCardDetails()" class="text-slate-400 hover:text-slate-700 transition p-1 rounded-full hover:bg-slate-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-100 space-y-3">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-bold">الحالة التشغيلية الحية:</span>
                        <span id="card-status-pill" class="px-3 py-1 rounded-full text-xs font-black bg-emerald-50 text-emerald-700 border border-emerald-200"></span>
                    </div>

                    <div id="card-capacity-wrapper" class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-bold">السعة الحالية:</span>
                            <span id="card-capacity-text" class="text-[#06205C] font-mono font-black"></span>
                        </div>
                        <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200">
                            <div id="card-capacity-bar" class="h-full bg-[#0066FF] transition-all duration-500" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet Script -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let leafMap, poiMarkers = [], poisData = [];

        document.addEventListener('DOMContentLoaded', () => {
            initLeafletRealMap();
        });

        function switchMapMode(mode) {
            const iframeContainer = document.getElementById('google-iframe-container');
            const streetviewContainer = document.getElementById('streetview-container');
            const leafletContainer = document.getElementById('leaflet-tile-container');
            const btnEmbed = document.getElementById('btn-mode-embed');
            const btnStreet = document.getElementById('btn-mode-streetview');
            const btnLeaflet = document.getElementById('btn-mode-leaflet');

            leafletContainer.classList.add('hidden');
            streetviewContainer.classList.add('hidden');
            iframeContainer.classList.add('hidden');

            btnEmbed.classList.remove('bg-[#0066FF]', 'text-white');
            btnStreet.classList.remove('bg-[#0066FF]', 'text-white');
            btnLeaflet.classList.remove('bg-[#0066FF]', 'text-white');
            btnEmbed.classList.add('text-slate-700');
            btnStreet.classList.add('text-slate-700');
            btnLeaflet.classList.add('text-slate-700');

            if (mode === 'EMBED') {
                iframeContainer.classList.remove('hidden');
                btnEmbed.classList.add('bg-[#0066FF]', 'text-white');
                btnEmbed.classList.remove('text-slate-700');
            } else if (mode === 'STREETVIEW') {
                streetviewContainer.classList.remove('hidden');
                btnStreet.classList.add('bg-[#0066FF]', 'text-white');
                btnStreet.classList.remove('text-slate-700');
            } else {
                leafletContainer.classList.remove('hidden');
                btnLeaflet.classList.add('bg-[#0066FF]', 'text-white');
                btnLeaflet.classList.remove('text-slate-700');

                if (leafMap) setTimeout(() => leafMap.invalidateSize(), 200);
            }
        }

        function initLeafletRealMap() {
            const container = document.getElementById('wsap-real-leaflet-map');
            if (!container) return;

            try {
                poisData = JSON.parse(container.dataset.pois || '[]');
            } catch (e) {
                poisData = [];
            }

            leafMap = L.map('wsap-real-leaflet-map', {
                center: [35.7471827, -0.5351771],
                zoom: 17,
                zoomControl: false
            });

            // HTTPS Google Satellite Hybrid Tile Layer
            const googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: 'Google Satellite | Mediterranean Village Oran'
            });

            googleHybrid.addTo(leafMap);
            L.control.zoom({ position: 'bottomleft' }).addTo(leafMap);

            // Check if custom boundary polygon was drawn by admin user
            let customBoundary = null;
            try {
                customBoundary = JSON.parse(container.dataset.boundary || 'null');
            } catch(e) {}

            let polyVertices = [
                [35.74950, -0.53620],
                [35.74400, -0.53720],
                [35.74350, -0.53200],
                [35.74650, -0.52900],
                [35.74880, -0.53100]
            ];
            let polyColor = '#EAB308';

            if (customBoundary && customBoundary.vertices && customBoundary.vertices.length > 0) {
                polyVertices = customBoundary.vertices;
                polyColor = customBoundary.color || '#EAB308';
            }

            // Boundary Polygon
            const boundaryPoly = L.polygon(polyVertices, {
                color: polyColor,
                fillColor: polyColor,
                fillOpacity: 0.18,
                weight: 4,
                dashArray: '8, 6'
            }).addTo(leafMap);

            boundaryPoly.bindTooltip("حرم القرية الأورومتوسطية بوهران — Mediterranean Village Boundary", { permanent: true, direction: "top" });

            poisData.forEach(poi => {
                const lat = poi.lat || (35.7471827 + (poi.pos_z / 110940.0));
                const lng = poi.lng || (-0.5351771 + (poi.pos_x / 90280.0));

                const html = `
                    <div class="wsap-3d-leaflet-pin group relative cursor-pointer" onclick="openPoiCardDetails(${poi.poi_id})">
                        <div class="w-11 h-11 rounded-2xl bg-white border-2 border-[#0066FF] shadow-2xl flex items-center justify-center text-[#0066FF]">
                            ${poi.svg_raw || ''}
                        </div>
                        <div class="absolute bottom-full mb-1 right-1/2 translate-x-1/2 whitespace-nowrap bg-white text-[#06205C] border border-[#0066FF]/30 text-[11px] font-black px-3 py-1 rounded-xl shadow-xl">
                            ${poi.title_ar}
                        </div>
                    </div>
                `;

                const customIcon = L.divIcon({
                    html: html,
                    className: 'wsap-poi-div-icon',
                    iconSize: [44, 44],
                    iconAnchor: [22, 22]
                });

                const marker = L.marker([lat, lng], { icon: customIcon }).addTo(leafMap);
                poiMarkers.push(marker);
            });
        }

        function openPoiCardDetails(poiId) {
            const poisDataContainer = document.getElementById('wsap-real-leaflet-map');
            let items = [];
            try {
                items = JSON.parse(poisDataContainer.dataset.pois || '[]');
            } catch(e) {}

            const poi = items.find(p => p.poi_id == poiId);
            if (!poi) return;

            document.getElementById('card-title').innerText = poi.title_ar;
            document.getElementById('card-subtitle').innerText = poi.building_code || 'القرية الأورومتوسطية بوهران';
            document.getElementById('card-icon-svg').innerHTML = poi.svg_raw || '';
            document.getElementById('card-status-pill').innerText = poi.status_label_ar || 'مفتوح';

            const capText = `${poi.occupancy_count || 0} / ${poi.capacity || 300} — (${poi.occupancy_pct || 0}%)`;
            document.getElementById('card-capacity-text').innerText = capText;
            document.getElementById('card-capacity-bar').style.width = `${poi.occupancy_pct || 0}%`;

            document.getElementById('poi-info-card').classList.remove('hidden');

            if (leafMap && poi.lat && poi.lng) {
                leafMap.flyTo([poi.lat, poi.lng], 18, { duration: 1 });
            }
        }

        function closePoiCardDetails() {
            document.getElementById('poi-info-card').classList.add('hidden');
        }
    </script>

    <style>
        .wsap-poi-div-icon {
            background: transparent !important;
            border: none !important;
        }
    </style>
</div>
