import { Calendar } from '@fullcalendar/core';
import listPlugin from '@fullcalendar/list';

export default {
    init() {
      var cal = new FullCalendar.Calendar(document.getElementById('calendar'), {
        plugins: [listPlugin],
        events: ajaxurl+"?action=get_events",
        defaultView: 'listMonth'
      });
    },
}
