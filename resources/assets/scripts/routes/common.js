export default {
  init() {
    // JavaScript to be fired on all pages
    $.trumbowyg.svgPath =
      "/wp-content/themes/solace-theme/dist/images/icons.svg";
    $("textarea").trumbowyg({
      btns: [["bold", "italic"], ["link"]],
    });

    // Register the service worker if available.
    if ("serviceWorker" in navigator) {
      navigator.serviceWorker
        .register(themepath+"/dist/scripts/sw.js")
        .then(function(reg) {
          console.log(
            "Successfully registered service worker",
            reg
          );
        })
        .catch(function(err) {
          console.warn(
            "Error whilst registering service worker",
            err
          );
        });
    }

    window.addEventListener(
      "online",
      function(e) {
        // Resync data with server.
        console.log("You are online");
      },
      false
    );

    window.addEventListener(
      "offline",
      function(e) {
        // Queue up events for server.
        console.log("You are offline");
      },
      false
    );

    // Check if the user is connected.
    if (navigator.onLine) {
    } else {
      // Show offline message
    }
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
