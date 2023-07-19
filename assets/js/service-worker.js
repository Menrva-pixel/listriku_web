const CACHE_NAME = 'Listriku-cache';
const urlsToCache = [
  '/', 
  '../../index.php',
  '../css/style.css',
  '/script.js',
  '../images/hero1.webp',
  '../images/hero2.webp',
  '../images/hero3.webp',
  '../images/proyek-2.webp',
  '../images/proyek-3.webp',
  '../images/service-1.webp',
];

self.addEventListener('install', event => {
    event.waitUntil(
      caches.open(CACHE_NAME)
        .then(cache => {
          return Promise.all(
            urlsToCache.map(url => {
              return fetch(url)
                .then(response => cache.put(url, response))
                .catch(error => console.error('Failed to cache:', error));
            })
          );
        })
    );
  });

self.addEventListener('fetch', event => {
    event.respondWith(
      caches.match(event.request)
        .then(response => {
          if (response) {
            return response; 
          }
  
          return fetch(event.request)
            .then(networkResponse => {
              if (networkResponse && networkResponse.status === 200) {
                const responseClone = networkResponse.clone();
                caches.open(CACHE_NAME)
                  .then(cache => cache.put(event.request, responseClone))
                  .catch(error => console.error('Error caching the response:', error));
              }
  
              return networkResponse;
            })
            .catch(error => {
              console.error('Error fetching the resource:', error);
            });
        })
    );
  });
  

self.addEventListener('activate', event => {
    event.waitUntil(
      caches.keys().then(cacheNames => {
        return Promise.all(
          cacheNames.filter(cacheName => cacheName !== CACHE_NAME)
            .map(cacheName => caches.delete(cacheName))
        );
      })
    );
  });
