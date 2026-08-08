const CACHE_NAME = 'wsap-2027-v1';
const ASSETS_TO_CACHE = [
  '/',
  '/manifest.json',
  '/LOGO01.png',
  '/logo.svg',
  '/lanyard-strap.png'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(ASSETS_TO_CACHE);
    })
  );
  self.skipWaiting();
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

self.addEventListener('fetch', (event) => {
  if (event.request.method !== 'GET') return;
  event.respondWith(
    caches.match(event.request).then((cachedResponse) => {
      if (cachedResponse) {
        return cachedResponse;
      }
      return fetch(event.request).catch(() => {
        return caches.match('/');
      });
    })
  );
});

// PWA Push Notification Event Listener
self.addEventListener('push', (event) => {
  let data = { 
    title: 'WorldSkills Algeria 2026 🇩🇿', 
    body: 'تنبيه جديد من لجنة التنظيم والنتائج الأولمبية', 
    icon: '/logo.svg', 
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
    icon: data.icon || '/logo.svg',
    badge: '/logo.svg',
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
