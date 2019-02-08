// Use a cacheName for cache versioning
var cacheName = "v1:static";

// During the installation phase, you'll usually want to cache static assets.
self.addEventListener("install", function(e) {
  // Once the service worker is installed, go ahead and fetch the resources to make this work offline.
  e.waitUntil(
    caches.open(cacheName).then(function(cache) {
      return cache
        .addAll([
          "./",
          "./dist/css/main.css",
          "./dist/js/main.js",
          "./dist/fonts/worksans-regular-webfont.woff",
          "./dist/fonts/worksans-regular-webfont.woff2",
          "./dist/fonts/worksans-bold-webfont.woff",
          "./dist/fonts/worksans-bold-webfont.woff2",
          "./dist/fonts/boycott-webfont.woff",
          "../../offline.html",
        ])
        .then(function() {
          self.skipWaiting();
        });
    })
  );
});

// when the browser fetches a URL…
self.addEventListener("fetch", function(event) {
  // … either respond with the cached object or go ahead and fetch the actual URL
  event.respondWith(
    caches.match(event.request).then(function(response) {
      if (response) {
        // retrieve from cache
        return response;
      }
      // fetch as normal
      return fetch(event.request);
    })
  );
});
