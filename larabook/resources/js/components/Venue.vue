<script setup>
import { onMounted, ref } from 'vue';
import axios from "axios";
import BookModal from './BookModal.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import CalendarView from './CalendarView.vue'

const date = ref();

const dateFrom = ref();
const dateTo = ref();

const onRangeStart = (value) => {
  const day = value.getDate();
  const month = value.getMonth() + 1;
  const year = value.getFullYear();
  const full = `${year}-${month}-${day}`;
  dateFrom.value = full;
}

const onRangeEnd = (value) => {
    const day = value.getDate();
    const month = value.getMonth() + 1;
    const year = value.getFullYear();
    const full = `${year}-${month}-${day}`;
    dateTo.value = full;
}

const handleDate = (modelData) => {
  date.value = modelData;
  // do something else with the data
}

const venue = ref([]);
const csrf = window.csrf_token;
const BookedDates = ref([]);
const products = ref([]);
const totalPrice = 10;
const addedProducts = ref([]);
const fullCalendar = ref([]);
// const calendarOptions = ref({
//         plugins: [ dayGridPlugin, interactionPlugin ],
//         initialView: 'dayGridMonth',
//         selectable: true,
        
// });

// const handleDateSelect = (arg) => {
//     console.log(arg);
// }

// const selectInfo = {
//     start: ''
// }

// console.log(BookedDates);
const url = new URL(window.location.href);
const queryParams = new URLSearchParams(url.search);

const getVenue = () => {
    axios.get('/venueRequest/' + queryParams.get('id'))
        .then(res => venue.value = res.data)
        // .then(getBookedDates())
        .then(getProducts())
        // .then(dDate())
        // .then(console.log(BookedDates))
        // .then(makeDatesThing())
        .catch(error => console.log(error))
}

// const getCSRF = () => {
//     axios.get('/sanctum/csrf-cookie')
//     .then(res => csrf.value =res.data)
//     .catch(error => console.log(error))
// }

// const getBookedDates = () => {
//     axios.get('/bookings/' + queryParams.get('id'))
//     .then(res => BookedDates.value =res.data)
//     .catch(error => console.log(error))
// }

const getProducts = () => {
    axios.get('/products/show/' + queryParams.get('userId'))
    .then(res => products.value =res.data)
    // .then(console.log(products))
    .catch(error => console.log(error))
}

onMounted(() => {
  getVenue();
});

// function addTotalPrice(addNumber) {
// totalPrice = totalPrice + addNumber;

// return totalPrice;
// }



// const handleSelect = ref('');

let showModal = ref(false);

// function makeDatesThing([BookedDates]) {
// for (let i = 0; i < BookedDates.length; i++) {
//     console.log("heyyya");
    
// }



</script>

<template>
    <div class="flex gap-10 flex-wrap">
        <div class="mainContainer flex items-center flex-col flex-wrap gap-3 w-fit justify-center">
        <h1 class="font-bold">{{ venue.name }}</h1>
        <div class="flex justify-between gap-11">
            <img :src="venue.image" class="object-cover h-48 w-96 align-start">
            <div class="">
                <h3>{{ venue.address }}</h3>
                <h4>{{ venue.city }}</h4>
                <h4>{{ venue.postal }}</h4>
                <h4>{{ venue.price }} NOK/day</h4>
                <h4>{{ venue.user_id }}</h4>
            </div>
        </div>
        <p>{{ venue.description }}</p>
        <button @click="showModal = true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
        Book Now
        </button>
        </div>
        <div class="flex flex-col">
            <h1 class="text-center text-5xl m-4">Availability</h1>
            <CalendarView class="calendar" />
        </div>
    </div>
    <Teleport to="body">
        <BookModal :show="showModal" :venue @close="showModal = false">
            <template #header>
                <h1>book venue: {{ venue.name }}</h1>
            </template>

            <template #default>
                <form id="booking-form" action="/bookings/store" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" :value="csrf" />
                    <VueDatePicker v-model="date" :model-value="date" @update:model-value="handleDate" :teleport="true" :enable-time-picker="false" :min-date="new Date()" range @range-start="onRangeStart" @range-end="onRangeEnd" model-type="yyyy.MM.dd"></VueDatePicker>
                    <input name="dateFrom" id="dateFrom" :value="dateFrom"/>
                    <input name="dateTo" id="dateTo" :value="dateTo" />
                    <h3>Add Products and Services</h3>
                    <div v-for="product in products" class="border">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4>{{ product.title }}</h4>
                                <h4>price: NOK {{ product.price }}</h4>
                                <p>{{ product.description }}</p>
                                <p>product id {{ product.id }}</p>
                            </div>
                            <div class="m-6">
                                <input type="checkbox" :value="product.id" v-model="addedProducts"  name="" id="">
                            </div>
                        </div>
                    </div>
                    <input type="" name="venue_id" id="venue_id" :value="venue.id" />
                    <input type="" name="products" value="ingenting"  />
                    <input type="" name="totalPrice" id="price" :value="totalPrice"  />
                    <input type="" name="productsAdded" id="" :value="addedProducts"  />
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

<style>
.calendar {
    height: 35rem;
    width: 30rem;
}
</style>