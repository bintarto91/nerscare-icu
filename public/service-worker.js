const CACHE_NAME = 'icu-assessment-pwa-v8';

const STATIC_ASSETS = [
    '/',
    '/manifest.json',
    '/manifest.json?v=8',
    '/offline.html',
    '/favicon.ico',
    '/icons/icon.svg',
    '/icons/icon.svg?v=8',
    '/icons/icon-192.png',
    '/icons/icon-192.png?v=8',
    '/icons/maskable-512.png',
    '/icons/maskable-512.png?v=8',
    '/icons/apple-touch-icon.png',
    '/icons/apple-touch-icon.png?v=8'
];

self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function (cache) {
            return cache.addAll(STATIC_ASSETS);
        })
    );

    self.skipWaiting();
});

self.addEventListener('activate', function (event) {
    event.waitUntil(
        caches.keys().then(function (cacheNames) {
            return Promise.all(
                cacheNames.map(function (cacheName) {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );

    self.clients.claim();
});

self.addEventListener('fetch', function (event) {
    if (event.request.method !== 'GET') {
        return;
    }

    const requestUrl = new URL(event.request.url);

    if (requestUrl.origin !== location.origin) {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then(function (response) {
                return response;
            })
            .catch(function () {
                if (event.request.mode === 'navigate') {
                    return caches.match('/offline.html');
                }

                return caches.match(event.request);
            })
    );
});
