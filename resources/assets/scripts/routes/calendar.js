import * as _ from 'underscore'

export default {
    init() {
        $(window).load(function() {
            $.ajax({
              url: ajaxurl,
              method: "POST",
              data: {
                action: "get_events",
              },
              dataType: 'JSON',
              success: function(data) {
                $("#calendar").clndr({
                  events: data,
                });
              },
            });
        });
    },
}
