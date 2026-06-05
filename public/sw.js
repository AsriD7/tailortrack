const CACHE_NAME = 'tailortrack-pwa-v1';
const BASE_PATH = new URL(self.registration.scope).pathname.replace(/\/$/, '');
const assetPath = (path) => `${BASE_PATH}${path}`;
const STATIC_ASSETS = [
  assetPath('/offline.html'),
  assetPath('/manifest.webmanifest'),
  assetPath('/images/tailortrack-icon.svg'),
  assetPath('/images/tailortrack-logo.svg'),
  assetPath('/images/tailortrack-icon-192.png'),
  assetPath('/images/tailortrack-icon-512.png')
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => cache.addAll(STATIC_ASSETS))
      .then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys()
      .then((keys) => Promise.all(
        keys
          .filter((key) => key !== CACHE_NAME)
          .map((key) => caches.delete(key))
      ))
      .then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (event) => {
  const { request } = event;

  if (request.method !== 'GET') {
    return;
  }

  const url = new URL(request.url);

  if (request.mode === 'navigate') {
    event.respondWith(
      fetch(request).catch(() => caches.match(assetPath('/offline.html')))
    );
    return;
  }

  if (url.origin === self.location.origin && STATIC_ASSETS.includes(url.pathname)) {
    event.respondWith(
      caches.match(request).then((cached) => cached || fetch(request))
    );
  }
});
