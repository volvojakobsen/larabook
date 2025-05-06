<script setup>
import { onMounted, ref } from 'vue';
import axios from "axios";
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

const url = new URL(window.location.href);
const queryParams = new URLSearchParams(url.search);

// Sample events
const events = ref([
    {
        title: 'Project Kickoff',
        start: '2025-05-07',
        end: '2025-05-09', // exclusive end date, will show 7th and 8th
    },
    {
        title: 'Conference',
        start: '2025-05-10',
        end: '2025-05-13',
    },
]);



const calendarOptions = ref({
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    events: events.value,
    selectable: true,
})

const BookedDates = ref([]);

function addToCalendar(dates) {
    var ocupiedDates = [];

    // if (!Array.isArray(dates)) {
    //     console.error('Expected an array of dates:', dates)
    //     return
    // }

    for (let i = 0; i < dates.length; i++) {
        ocupiedDates.push(
            {
                title: 'ocupied',
                start: dates[i].dateFrom,
                end: dates[i].dateTo, // exclusive end date, will show 7th and 8th
            })
        console.log(ocupiedDates);
    };

    console.log(dates);
    console.log(ocupiedDates);
}

const getBookedDates = () => {
    axios.get('/bookings/' + queryParams.get('id'))
        .then(res => BookedDates.value = res.data)
        // .then(console.log(BookedDates))
        .then(addToCalendar(Array.from(BookedDates)))
        .catch(error => console.log(error))
}

onMounted(() => {
    getBookedDates();
});
</script>


<template>
    <FullCalendar :options="calendarOptions" />
</template>