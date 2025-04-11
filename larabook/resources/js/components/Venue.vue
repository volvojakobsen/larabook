<script setup>
import { onMounted, ref } from 'vue';
import axios from "axios";
import BookModal from './BookModal.vue';
import VueTailwindDatepicker from "vue-tailwind-datepicker";

const dateValue = ref({
  startDate: "",
  endDate: "",
});
const formatter = ref({
  date: 'DD MMM YYYY',
  month: 'MMM',
});


const startFrom = new Date(2025, 3, 11);

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
// }

function dDate(date) {
  return date < new Date(2025, 3, 14) || date > new Date(2025, 3, 17)
}


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
        Button
    </button>
    <Teleport to="body">
        <BookModal :show="showModal" :venue @close="showModal = false">
            <template #header>
                <h1>book venue: {{ venue.name }}</h1>
            </template>

            <template #default>
                <form id="booking-form" action="/bookings/store" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" :value="csrf" />
                    <vue-tailwind-datepicker overlay :shortcuts="false" input-classes="block mb-2 text-sm font-medium text-green-700 dark:text-green-500" 
                    v-model="dateValue" :disable-in-range="dDate" :start-from="startFrom"  as-single use-range placeholder="Select Dates From/To"/>
                    <input disabled name="dateFrom" id="dateFrom" :value="dateValue.startDate"/>
                    <input  name="dateTo" id="dateTo" :value="dateValue.endDate"/>
                    <input type="hidden" name="venue_id" :value="venue.id"  />
                    <input type="hidden" name="products" value="ingenting"  />
                    <input type="hidden" name="totalPrice" id="price" :value="venue.price"  />
                    <!-- <h1>{{ dateValue.startDate.toISOString().split('T')[0] }}</h1> -->
                     <h1 :value="dateValue.startDate"></h1>
                     <input disabled :value="dateValue.startDate"/>
                    

                </form>
            </template>

            <template #footer>
                <div class="flex justify-between">
                    <button @click="showModal = false"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                            cancel
                        </button>
                <button form="booking-form" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Submit</button>
                </div>
            </template>
        </BookModal>
    </Teleport>
</template>