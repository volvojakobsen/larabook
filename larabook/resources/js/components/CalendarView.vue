<script setup>
import { onMounted, ref, nextTick } from 'vue';
import axios from "axios";
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

const url = new URL(window.location.href);
const queryParams = new URLSearchParams(url.search);

const user = window.App.user;
const isLoggedIn = !!user;

const emit = defineEmits(['select-range']); // 👈 define the emit

let events = ref([]);




const calendarOptions = ref({
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    events: events,
    selectable: true,
    validRange: {
        start: new Date().toISOString().split('T')[0]
    },
    selectAllow(selectInfo) {
        const startDateStr = selectInfo.startStr;
        const endDateStr = selectInfo.endStr;

        for (let event of events.value) {
            if (
                startDateStr < event.end &&
                endDateStr > event.start
            ) {
                return false;
            }
        }

        return true;
    },
    select: function(info) {
        if (!isLoggedIn) {
        return; // 🚫 Don't emit anything if user isn't logged in
    }
        // 👇 Emit start and end dates to parent (end is exclusive, subtract 1 day)
        const startDate = info.startStr;
        const endDate = new Date(info.endStr);
        endDate.setDate(endDate.getDate() - 1); // FullCalendar's end is exclusive

        emit('select-range', {
            dateFrom: startDate,
            dateTo: endDate.toISOString().split('T')[0]
        });
    },
    eventDidMount(info) {
        nextTick(() => {
            if (info.event.title === 'Unavailable') {
                const titleEl = info.el.querySelector('.fc-event-title');
                const eventEl = info.el;
                if (titleEl) {
                    titleEl.style.position = 'absolute';
                    titleEl.style.top = '50%';
                    titleEl.style.transform = 'translateY(-50%)';
                    titleEl.style.left = '5px';
                    eventEl.style.backgroundColor = 'rgba(255, 0, 0, 0.3)';
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

