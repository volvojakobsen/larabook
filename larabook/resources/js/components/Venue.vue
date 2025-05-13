<script setup>
import { onMounted, ref, computed } from 'vue';
import axios from "axios";
import BookModal from './BookModal.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import CalendarView from './CalendarView.vue';



const dateFrom = ref('');
const dateTo = ref('');
const date = ref();

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
const addedProducts = ref([]);
const products = ref([]);

const bookingDays = computed(() => {
  if (!dateFrom.value || !dateTo.value) return 0;
  const start = new Date(dateFrom.value);
  const end = new Date(dateTo.value);
  const diffTime = end - start;
  const dayCount = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

  return dayCount + 1; // ✅ Include the end date
});

const totalPrice = computed(() => {
  const productTotal = products.value
    .filter(product => addedProducts.value.includes(product.id))
    .reduce((sum, product) => sum + parseFloat(product.price), 0);

  const venueDaily = parseFloat(venue.value.price || 0);
  return (venueDaily * bookingDays.value) + productTotal;
});

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
        .then(res => products.value = res.data)
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
const id = ref();
console.log(id);

const handleCalendarRangeSelect = ({ dateFrom: from, dateTo: to }) => {
  dateFrom.value = from;
  dateTo.value = to;
  showModal.value = true;
};

// redo formrequest to axios post request
const bookVenue = async () => {
    console.log('registering');
    try {
        const response = await axios.post('/bookings/store', {
            dateFrom: dateFrom.value,
            dateTo: dateTo.value,
            venue_id: venue.value.id,
            totalPrice: totalPrice.value,
            products: addedProducts.value, // Ensure 'products' is the correct field
        }, {
            headers: {
            }
        });
        console.log(response.data);  // Log successful response
    } catch (error) {
        console.error('Caught error:', error);
    }


};
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
            <button @click="showModal = true"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                Book Now
            </button>
        </div>
        <div class="flex flex-col">
            <h1 class="text-center text-5xl m-4">Availability</h1>
            <CalendarView class="calendar" @select-range="handleCalendarRangeSelect" />
        </div>
    </div>
    <Teleport to="body">
        <BookModal :show="showModal" :venue @close="showModal = false">
            <template #header>
                <h1>book venue: {{ venue.name }}</h1>
            </template>
            <!-- <input name="products[]" value="x"> -->
            <template #default>
                <form id="booking-form" action="/bookings/store" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" :value="csrf" />
                    <VueDatePicker v-model="date" :model-value="date" @update:model-value="handleDate" :teleport="true"
                        :enable-time-picker="false" :min-date="new Date()" range @range-start="onRangeStart"
                        @range-end="onRangeEnd" model-type="yyyy.MM.dd"></VueDatePicker>
                    <input name="dateFrom" id="dateFrom" :value="dateFrom" />
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
                                <input type="checkbox" :value="product.id" v-model="addedProducts" name="" id="">
                            </div>
                        </div>
                    </div>
                    <input type="" v-bind="id" name="venue_id" id="venue_id" :value="venue.id" />
                    <input type="" name="products" value="ingenting" />
                    <input type="" name="totalPrice" id="price" :value="totalPrice" />
                    <input type="" name="productsAdded" id="" :value="addedProducts" />
                    <h3>Total Selected Product Price: NOK {{ totalPrice }}</h3>
                    <!-- <h1>{{ dateValue.startDate.toISOString().split('T')[0] }}</h1> -->


                </form>
            </template>

            <template #footer>
                <div class="flex justify-between">
                    <button @click="showModal = false"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                        cancel
                    </button>
                    <button @click="bookVenue"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Book</button>
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