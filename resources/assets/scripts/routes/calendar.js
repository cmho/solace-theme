export default {
    init() {
        $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: {
                action: 'get_events',
            },
            success: function(data) {
                $('#calendar').clndr({
                    events: data,
                });
            },
        });
    },
}