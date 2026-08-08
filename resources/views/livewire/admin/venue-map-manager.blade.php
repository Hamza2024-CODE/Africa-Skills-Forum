<div class="w-full font-sans dir-rtl space-y-6" dir="rtl">
    <!-- Leaflet CSS & Leaflet Draw CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />

    <!-- Light Blue & White Header Bar -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200/90 dark:border-slate-700 shadow-xl">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#EEF6FF] dark:bg-blue-950/60 border border-[#0066FF]/30 flex items-center justify-center text-[#0066FF] dark:text-sky-400 shadow-sm">
                <svg class="w-7 h-7 text-[#0066FF] dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2V4zm-6 8a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2v-1zm12 0a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2v-1zM4 18a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2v-1zm12 0a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2v-1z"/></svg>
            </div>
            <div>
                <h1 class="text-xl font-black text-[#06205C] dark:text-white tracking-wide">3D Venue Builder & Command Center — WSAP Digital Twin</h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs font-bold text-[#0066FF] dark:text-sky-400">مركز التحكم ورسم الحدود بالستلايت — القرية الأورومتوسطية بوهران (35.7471827, -0.5351771)</span>
                    <a href="{{ route('venue-map') }}" target="_blank" class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-blue-50 dark:bg-blue-950 text-[#0066FF] dark:text-sky-300 border border-blue-200 dark:border-blue-800 flex items-center gap-1 hover:bg-blue-100 transition">
                        معاينة العرض العام ↗
                    </a>
                </div>
            </div>
        </div>

        <!-- Mode Controls & Emergency Toggle -->
        <div class="flex items-center gap-3">
            <div class="bg-slate-100 dark:bg-slate-900 p-1.5 rounded-2xl border border-slate-200 dark:border-slate-700 flex gap-1">
                <button wire:click="setMode('BUILDER')" class="px-3.5 py-2 rounded-xl text-xs font-black transition {{ ($activeMode ?? 'BUILDER') === 'BUILDER' ? 'bg-[#0066FF] text-white shadow-md shadow-blue-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-[#0066FF]' }}">
                    نمط السحب ورسم الحدود (Builder)
                </button>
                <button wire:click="setMode('LIVE_OPERATIONS')" class="px-3.5 py-2 rounded-xl text-xs font-black transition {{ ($activeMode ?? 'BUILDER') === 'LIVE_OPERATIONS' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-emerald-700' }}">
                    المراقبة الحية (Live Ops)
                </button>
            </div>

            <!-- Emergency Evacuation Trigger Button -->
            <button wire:click="toggleEmergencyMode" class="px-4 py-2.5 rounded-2xl text-xs font-black transition flex items-center gap-2 {{ ($emergencyActive ?? false) ? 'bg-rose-600 text-white animate-pulse shadow-lg shadow-rose-500/30' : 'bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800 hover:bg-rose-100' }}">
                <svg class="w-4 h-4 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                {{ ($emergencyActive ?? false) ? 'إلغاء نمط الطوارئ' : 'تفعيل وضع الطوارئ' }}
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-emerald-50 dark:bg-emerald-950 border border-emerald-200 dark:border-emerald-800 rounded-2xl text-emerald-800 dark:text-emerald-200 text-xs font-black flex items-center justify-between shadow-sm animate-bounce">
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- Main Builder Grid: Sidebar Panel + Map Viewport -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        <!-- Sidebar Admin Panel (Lists POIs, Polygon Draw Tools, Database Controls) -->
        <div class="space-y-6 lg:col-span-1">
            
            <!-- Drawing Tool Control Card -->
            <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200/90 dark:border-slate-700 shadow-xl space-y-4">
                <h3 class="text-sm font-black text-[#06205C] dark:text-white tracking-wide flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    أداة رسم الحدود الميدانية (Draw Boundary)
                </h3>

                <div class="space-y-3 text-xs">
                    <p class="text-slate-600 dark:text-slate-300 font-bold leading-relaxed">
                        استخدم أدوات الرسم لترسم الحدود الصفراء أو الحمراء المخصصة لحرم القرية:
                    </p>

                    <div class="flex gap-2">
                        <button type="button" onclick="startDrawingPolygon('#EAB308')" class="flex-1 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-black transition shadow-sm flex items-center justify-center gap-1">
                            رسم خط أصفر 🟡
                        </button>
                        <button type="button" onclick="startDrawingPolygon('#EF4444')" class="flex-1 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-black transition shadow-sm flex items-center justify-center gap-1">
                            رسم خط أحمر 🔴
                        </button>
                    </div>

                    <button type="button" id="btn-save-drawn-polygon" onclick="saveDrawnPolygon()" class="hidden w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-black transition shadow-md shadow-emerald-500/20">
                        تثبيت وحفظ رسم الحدود الجديد 💾
                    </button>
                </div>
            </div>

            <!-- Edit Selected POI Form -->
            <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200/90 dark:border-slate-700 shadow-xl space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-black text-[#06205C] dark:text-white tracking-wide flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#0066FF] dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        تعديل المكون المكاني المباشر
                    </h3>
                </div>

                @if($selectedPoiId ?? null)
                    <div class="space-y-3 text-xs">
                        <div>
                            <label class="block text-slate-500 font-bold mb-1">اسم العنصر (العربية):</label>
                            <input type="text" wire:model="editTitleAr" class="w-full px-3 py-2 border border-slate-300 rounded-xl font-bold text-slate-800 focus:outline-none focus:border-[#0066FF]">
                        </div>

                        <div>
                            <label class="block text-slate-500 font-bold mb-1">الحالة التشغيلية:</label>
                            <select wire:model="editStatus" class="w-full px-3 py-2 border border-slate-300 rounded-xl font-bold text-slate-800 focus:outline-none focus:border-[#0066FF]">
                                <option value="OPEN">مفتوح (OPEN)</option>
                                <option value="LIVE_COMPETITION">المنافسة جارية (LIVE)</option>
                                <option value="RESTRICTED">منطقة مقيدة (RESTRICTED)</option>
                                <option value="CLOSED">مغلق (CLOSED)</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-slate-500 font-bold mb-1">الإحداثي X (متر):</label>
                                <input type="number" step="0.5" wire:model="editPosX" class="w-full px-3 py-2 border border-slate-300 rounded-xl font-bold text-slate-800">
                            </div>
                            <div>
                                <label class="block text-slate-500 font-bold mb-1">الإحداثي Z (متر):</label>
                                <input type="number" step="0.5" wire:model="editPosZ" class="w-full px-3 py-2 border border-slate-300 rounded-xl font-bold text-slate-800">
                            </div>
                        </div>

                        <button wire:click="savePoiTransform" class="w-full py-2.5 bg-[#0066FF] hover:bg-blue-700 text-white rounded-xl font-black text-xs transition shadow-md shadow-blue-500/20">
                            حفظ وتثبيت الموقع 💾
                        </button>
                    </div>
                @else
                    <div class="bg-blue-50/60 p-4 rounded-2xl border border-blue-100 text-center space-y-2">
                        <p class="text-xs text-[#0066FF] font-black">💡 يمكنك سحب وإسقاط أي دبوس على الخريطة مباشرة!</p>
                        <p class="text-[11px] text-slate-500 font-bold">بمجرد سحب الدبوس وإفلاته في المكان الصحيح، سيتم تثبيته وحفظه فوراً في قاعدة البيانات MySQL.</p>
                    </div>
                @endif
            </div>

            <!-- List of All POIs in Database -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-xl space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-black text-[#06205C] tracking-wide">قائمة المكونات المسجلة</h3>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-blue-50 text-[#0066FF] border border-blue-200">
                        {{ count($pois) }} كيانات
                    </span>
                </div>
                <div class="space-y-2 max-h-[380px] overflow-y-auto pr-1">
                    @foreach($pois as $poi)
                        <div wire:click="selectPoi({{ $poi['poi_id'] }})" class="p-3 bg-slate-50 dark:bg-slate-900 rounded-2xl border {{ ($selectedPoiId ?? null) === $poi['poi_id'] ? 'border-[#0066FF] bg-blue-50 dark:bg-blue-950' : 'border-slate-200 dark:border-slate-700' }} flex items-center justify-between text-xs hover:border-[#0066FF] transition cursor-pointer">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-[#0066FF] dark:text-sky-400 shadow-sm">
                                    {!! $poi['svg_raw'] ?? '' !!}
                                </div>
                                <div>
                                    <h4 class="font-black text-[#06205C] dark:text-white">{{ $poi['title_ar'] }}</h4>
                                    <p class="text-[10px] text-slate-400 font-bold">{{ $poi['building_code'] ?? 'القرية الأورومتوسطية' }}</p>
                                </div>
                            </div>
                            <span class="text-[10px] text-slate-500 font-mono font-bold">({{ $poi['pos_x'] }}, {{ $poi['pos_z'] }})</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Real Satellite Map Viewport Box (Always Mounted in DOM + wire:ignore to prevent White Screen) -->
        <div class="lg:col-span-3 bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/90 dark:border-slate-700 h-[650px] min-h-[650px] relative overflow-hidden shadow-2xl">
            <!-- Leaflet Container PERMANENTLY Mounted with wire:ignore -->
            <div wire:ignore id="admin-leaflet-builder-map" data-pois='@json($pois)' data-boundary='@json($customBoundary ?? null)' style="width: 100%; height: 650px; min-height: 650px;"></div>
        </div>
    </div>

    <!-- Leaflet & Leaflet Draw Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script>
        let adminMap = null, drawnItems = null, polygonDrawer = null, activePolygonColor = '#EAB308', currentDrawnPolygon = null;

        document.addEventListener('DOMContentLoaded', () => {
            initAdminMap();
        });

        // Re-fix Leaflet canvas sizes on Livewire updates (prevents white screen)
        document.addEventListener('livewire:updated', () => {
            if (adminMap) {
                setTimeout(() => adminMap.invalidateSize(), 150);
            }
        });

        function initAdminMap() {
            const container = document.getElementById('admin-leaflet-builder-map');
            if (!container) return;

            // If map already exists, invalidate size and return
            if (adminMap) {
                adminMap.invalidateSize();
                return;
            }

            let poisData = [];
            try {
                poisData = JSON.parse(container.dataset.pois || '[]');
            } catch (e) {
                poisData = [];
            }

            adminMap = L.map('admin-leaflet-builder-map', {
                center: [35.7471827, -0.5351771],
                zoom: 17,
                zoomControl: false
            });

            const googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: 'Google Satellite | Mediterranean Village Oran'
            });

            googleHybrid.addTo(adminMap);
            L.control.zoom({ position: 'bottomleft' }).addTo(adminMap);

            // Layer group for drawn polygons
            drawnItems = new L.FeatureGroup();
            adminMap.addLayer(drawnItems);

            // Load Custom Drawn Boundary if exists, otherwise fallback to default
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

            const boundaryPoly = L.polygon(polyVertices, {
                color: polyColor,
                fillColor: polyColor,
                fillOpacity: 0.18,
                weight: 4,
                dashArray: '8, 6'
            }).addTo(adminMap);

            boundaryPoly.bindTooltip("حرم القرية الأورومتوسطية بوهران — Mediterranean Village Boundary", { permanent: true, direction: "top" });

            // Drawing control listener
            adminMap.on(L.Draw.Event.CREATED, function (e) {
                const layer = e.layer;
                drawnItems.clearLayers();
                drawnItems.addLayer(layer);
                currentDrawnPolygon = layer;

                const btnSave = document.getElementById('btn-save-drawn-polygon');
                if (btnSave) btnSave.classList.remove('hidden');
            });

            poisData.forEach(poi => {
                const lat = poi.lat || (35.7471827 + (poi.pos_z / 110940.0));
                const lng = poi.lng || (-0.5351771 + (poi.pos_x / 90280.0));

                const html = `
                    <div class="wsap-leaflet-pin group relative cursor-pointer">
                        <div class="w-11 h-11 rounded-2xl bg-white border-2 border-[#0066FF] shadow-2xl flex items-center justify-center text-[#0066FF]">
                            ${poi.svg_raw || ''}
                        </div>
                        <div class="absolute bottom-full mb-1 right-1/2 translate-x-1/2 whitespace-nowrap bg-[#06205C] text-white text-[11px] font-black px-3 py-1 rounded-xl shadow-xl">
                            ${poi.title_ar} ✋ (اسحب للتعديل)
                        </div>
                    </div>
                `;

                const customIcon = L.divIcon({
                    html: html,
                    className: 'wsap-poi-div-icon',
                    iconSize: [44, 44],
                    iconAnchor: [22, 22]
                });

                // ENABLE DRAGGING FOR USER POSITIONING
                const marker = L.marker([lat, lng], {
                    icon: customIcon,
                    draggable: true
                }).addTo(adminMap);

                marker.on('dragend', function (event) {
                    const position = marker.getLatLng();
                    if (window.Livewire) {
                        const component = Livewire.find(container.closest('[wire\\:id]').getAttribute('wire:id'));
                        if (component) {
                            component.call('updatePoiLatLng', poi.poi_id, position.lat, position.lng);
                        }
                    }
                });
            });
        }

        function startDrawingPolygon(color) {
            activePolygonColor = color;
            if (!adminMap) return;

            if (polygonDrawer) polygonDrawer.disable();

            polygonDrawer = new L.Draw.Polygon(adminMap, {
                shapeOptions: {
                    color: color,
                    fillColor: color,
                    fillOpacity: 0.25,
                    weight: 4
                }
            });
            polygonDrawer.enable();
        }

        function saveDrawnPolygon() {
            if (!currentDrawnPolygon) return;
            const latLngs = currentDrawnPolygon.getLatLngs()[0];
            const coords = latLngs.map(p => [p.lat, p.lng]);

            const container = document.getElementById('admin-leaflet-builder-map');
            if (window.Livewire && container) {
                const component = Livewire.find(container.closest('[wire\\:id]').getAttribute('wire:id'));
                if (component) {
                    component.call('saveBoundaryPolygon', coords, activePolygonColor);
                }
            }
        }
    </script>

    <style>
        .wsap-poi-div-icon {
            background: transparent !important;
            border: none !important;
        }
    </style>
</div>
