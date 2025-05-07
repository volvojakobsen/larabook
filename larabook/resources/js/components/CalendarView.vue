<script setup>
import { onMounted, ref, nextTick } from 'vue';
import axios from "axios";
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

const url = new URL(window.location.href);
const queryParams = new URLSearchParams(url.search);


let events = ref([]);


const calendarOptions = ref({
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    events: events,
    selectable: true,
    // making the past dates unavailable
    validRange: {
        start: new Date().toISOString().split('T')[0]
    },
    // taking the dates from event array and making them unavailable
    selectAllow(selectInfo) {
        const startDateStr = selectInfo.startStr; // YYYY-MM-DD
        const endDateStr = selectInfo.endStr;     // YYYY-MM-DD (exclusive)

        for (let event of events.value) {
            const eventStartStr = event.start;
            const eventEndStr = event.end;

            if (
                startDateStr < eventEndStr && // overlap starts before event ends
                endDateStr > eventStartStr    // overlap ends after event starts
            ) {
                return false;
            }
        }

        return true;
    },
    // styles the unavailable dates and making them non selectable
    eventDidMount: function(info) {
    nextTick(() => {
        if (info.event.title === 'Unavailable') {
            const titleEl = info.el.querySelector('.fc-event-title');
            const eventEl = info.el;  // Get the event element
            if (titleEl) {
                // Move the title down and center it
                titleEl.style.position = 'absolute';
                titleEl.style.top = '50%';
                titleEl.style.transform = 'translateY(-50%)';
                titleEl.style.left = '5px';

                // Change background color dynamically
                eventEl.style.backgroundColor = 'rgba(255, 0, 0, 0.3)'; // light red
            }
        }
    });
}
});


function addToCalendar(dates) {
    for (let i = 0; i < dates.length; i++) {
        const startDate = dates[i].dateFrom;
        const endDate = new Date(dates[i].dateTo);
        endDate.setDate(endDate.getDate() + 1); // Add 1 day

        events.value.push({
            title: 'Unavailable',
            start: startDate,
            end: endDate.toISOString().split('T')[0], // format as YYYY-MM-DD
            display: 'background', // optional, see below
            classNames: ['unavailable-date', 'fc-daygrid-event', 'fc-daygrid-event-title', 'fc-event-title'],
        });
    }

    // console.log(dates);
    // console.log(events.value);
    return events.value;
}

const getBookedDates = () => {
    axios.get('/bookings/' + queryParams.get('id'))
        .then(res => addToCalendar(res.data))
        .catch(error => console.log(error))
}
//  return response()->json('array')
onMounted(() => {
    getBookedDates();
});
</script>


<template>
    <FullCalendar :options="calendarOptions" />
</template>

