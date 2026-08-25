const CACHE_NAME = 'asf-2026-v7';
const ASSETS_TO_CACHE = [
  '/manifest.json',
  '/manifest.webmanifest',
  '/icon-192.png',
  '/icon-512.png',
  '/LOGO01.png'
];

self.addEventListener('install', (event) => {
  self.skipWaiting();
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(ASSETS_TO_CACHE))
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cache) => {
          if (cache !== CACHE_NAME) {
            return caches.delete(cache);
          }
        })
      );
    })
  );
  self.clients.claim();
});

self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});

self.addEventListener('fetch', (event) => {
  const request = event.request;
  const url = new URL(request.url);

  // 1. Never intercept non-GET requests (POST, PUT, DELETE)
  if (request.method !== 'GET') return;

  // 2. Never intercept Livewire endpoints, uploads, previews, admin panel, or API routes
  if (
    url.pathname.includes('livewire') ||
    url.pathname.includes('upload-file') ||
    url.pathname.includes('preview-file') ||
    url.pathname.startsWith('/api') ||
    url.pathname.startsWith('/panel') ||
    url.searchParams.has('signature') ||
    url.searchParams.has('expires')
  ) {
    return;
  }

  // 3. Network-Only for HTML navigation pages (Never cache HTML pages to prevent stale CSRF tokens)
  if (request.mode === 'navigate' || request.headers.get('accept')?.includes('text/html')) {
    event.respondWith(
      fetch(request).catch(() => caches.match(request).then((cached) => cached || fetch(request)))
    );
    return;
  }

  // 4. Stale-While-Revalidate for static assets (images, css, js)
  event.respondWith(
    caches.match(request).then((cachedResponse) => {
      const fetchPromise = fetch(request).then((networkResponse) => {
        if (networkResponse && networkResponse.status === 200) {
          const responseClone = networkResponse.clone();
          caches.open(CACHE_NAME).then((cache) => cache.put(request, responseClone));
        }
        return networkResponse;
      }).catch(() => {});

      return cachedResponse || fetchPromise;
    })
  );
});

// PWA Push Notification Event Listener
self.addEventListener('push', (event) => {
  let data = { 
    title: 'Africa Skills Forum 2026', 
    body: 'تنبيه جديد من منتدى المهارات الإفريقية', 
    icon: '/icon-192.png', 
    url: '/notifications' 
  };

  try {
    if (event.data) {
      const payload = event.data.json();
      data = Object.assign(data, payload);
    }
  } catch (e) {
    if (event.data) {
      data.body = event.data.text();
    }
  }

  const options = {
    body: data.body,
    icon: data.icon || '/icon-192.png',
    badge: '/icon-192.png',
    vibrate: [200, 100, 200, 100, 200],
    data: { url: data.url || '/notifications' },
    tag: 'wsap-notification-' + Date.now(),
    renotify: true,
    actions: [
      { action: 'open', title: 'عرض الإشعار (View)' }
    ]
  };

  event.waitUntil(
    self.registration.showNotification(data.title, options)
  );
});

// Notification Click Listener
self.addEventListener('notificationclick', (event) => {
  event.notification.close();
  const targetUrl = event.notification.data ? event.notification.data.url : '/notifications';
  
  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
      for (const client of clientList) {
        if (client.url.includes(targetUrl) && 'focus' in client) {
          return client.focus();
        }
      }
      if (clients.openWindow) {
        return clients.openWindow(targetUrl);
      }
    })
  );
});
