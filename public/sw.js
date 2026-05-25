const CACHE_NAME = 'cidade-do-saber-v1';
const urlsToCache = [
  '/sua-rota-da-carteirinha-aqui',
  // Se usar as fontes e scripts do CDN, pode adicioná-los aqui para funcionar 100% offline
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(urlsToCache))
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        // Cache first, fallback to network
        return response || fetch(event.request);
      })
  );
});