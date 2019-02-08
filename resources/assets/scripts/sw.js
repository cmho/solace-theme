// Use a cacheName for cache versioning
var cacheName = "v1:static";
var themepath = "/wp-content/themes/solace-theme/";

// During the installation phase, you'll usually want to cache static assets.
self.addEventListener("install", function(e) {
  // Once the service worker is installed, go ahead and fetch the resources to make this work offline.
  e.waitUntil(
    caches.open(cacheName).then(function(cache) {
      return cache
        .addAll([
          themepath + "/storyteller-dashboard/",
          themepath + "/dist/styles/main.css",
          themepath + "/dist/scripts/main.js",
          themepath + "/dist/fonts/worksans-regular-webfont.woff",
          themepath + "/dist/fonts/worksans-regular-webfont.woff2",
          themepath + "/dist/fonts/worksans-bold-webfont.woff",
          themepath + "/dist/fonts/worksans-bold-webfont.woff2",
          themepath + "/dist/fonts/boycott-webfont.woff",
          themepath + "/offline.html",
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
