<script setup>
import { onMounted, ref } from 'vue';
import axios from "axios";
import BookModal from './BookModal.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const date = ref([]);

const dateFrom = ref();
const dateTo = ref();

const onRangeStart = (value) => {
  dateFrom.value = new Date(value);
}

const onRangeEnd = (value) => {
    dateTo.value = new Date(value);
}

const handleDate = (modelData) => {
  date.value = modelData;
  // do something else with the data
}

const venue = ref([]);
const csrf = window.csrf_token;
const BookedDates = ref([]);

// console.log(BookedDates);
const url = new URL(window.location.href);
const queryParams = new URLSearchParams(url.search);

const getVenue = () => {
    axios.get('/venueRequest/' + queryParams.get('id'))
        .then(res => venue.value = res.data)
        .then(getBookedDates())
        // .then(dDate())
        .then(console.log(BookedDates))
        // .then(makeDatesThing())
        .catch(error => console.log(error))
}

const getCSRF = () => {
    axios.get('/sanctum/csrf-cookie')
    .then(res => csrf.value =res.data)
    .catch(error => console.log(error))
}

const getBookedDates = () => {
    axios.get('/bookings/' + queryParams.get('id'))
    .then(res => BookedDates.value =res.data)
    .catch(error => console.log(error))
}

onMounted(() => getVenue());

let showModal = ref(false);

// function makeDatesThing([BookedDates]) {
// for (let i = 0; i < BookedDates.length; i++) {
//     console.log("heyyya");
    
// }



</script>

<template>
    <div class="mainContainer flex items-center flex-col flex-wrap gap-3 w-fit justify-center">
        <h1 class="font-bold">{{ venue.name }}</h1>
        <div class="flex justify-between gap-11">
            <img :src="venue.image" class="object-cover h-48 w-96 align-start">
            <div class="">
                <h3>{{ venue.address }}</h3>
                <h4>{{ venue.city }}</h4>
                <h4>{{ venue.postal }}</h4>
                <h4>{{ venue.price }} NOK/day</h4>
            </div>
        </div>
        <p>{{ venue.description }}</p>
    </div>
    <button @click="showModal = true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
        Book Now
    </button>
    <Teleport to="body">
        <BookModal :show="showModal" :venue @close="showModal = false">
            <template #header>
                <h1>book venue: {{ venue.name }}</h1>
            </template>

            <template #default>
                <form id="booking-form" action="/bookings/store" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" :value="csrf" />
                    <VueDatePicker v-model="date" @update:model-value="handleDate" :teleport="true" :enable-time-picker="false" :min-date="new Date()" range ></VueDatePicker>
                    <input name="dateFrom" id="dateFrom" :value="dateFrom"/>
                    <input name="dateTo" id="dateTo" :value="dateTo" />
                    <input type="" name="venue_id" id="venue_id" :value="venue.id" />
                    <input type="" name="products" value="ingenting"  />
                    <input type="" name="totalPrice" id="price" :value="venue.price"  />
                    <!-- <h1>{{ dateValue.startDate.toISOString().split('T')[0] }}</h1> -->
                    

                </form>
            </template>

            <template #footer>
                <div class="flex justify-between">
                    <button @click="showModal = false"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                            cancel
                        </button>
                <button form="booking-form" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Book</button>
                </div>
            </template>
        </BookModal>
    </Teleport>
</template>