<script setup>
import { onMounted, ref, computed } from 'vue';
import axios from "axios";
import BookModal from './BookModal.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import CalendarView from './CalendarView.vue';
import { toast } from 'vue3-toastify'



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
                'Content-Type': 'application/json',
            }
        });
        console.log(response.data);
        toast.success('Booking successful! Redirecting...', {
            autoClose: 2000, // Toast disappears in 2s
            onClose: () => {
                window.location.href = '/'; // ✅ Laravel route
            }
        });
    } catch (error) {
        // Laravel validation error (status code 422)
        if (error.response?.status === 422) {
            const errors = error.response.data.errors;
            if (errors) {
                // Show the first error message found
                const firstError = Object.values(errors)[0][0];
                toast.error(firstError);
            } else {
                toast.error('Validation failed. Please check your input.');
            }

            // Other known Laravel error response
        } else if (error.response?.data?.message) {
            toast.error(error.response.data.message);

            // Network/server error
        } else {
            toast.error('Something went wrong. Please try again.');
        }

        console.error('Booking error:', error);
    }


};
</script>

<template>
    <div class="flex flex-col lg:flex-row gap-10 p-4 max-w-7xl mx-auto">
        <!-- Venue Info Section -->
        <div class="flex-1 space-y-6">
            <!-- Venue Name -->
            <h1 class="text-3xl font-bold text-gray-800">{{ venue.name }}</h1>

            <!-- Image & Address Block -->
            <div class="flex flex-col sm:flex-row gap-6">
                <!-- Venue Image -->
                <img :src="venue.image" alt="Venue Image" class="object-cover w-full sm:w-80 h-48 rounded shadow-md" />

                <!-- Address Info -->
                <div class="text-gray-700 space-y-1">
                    <p class="text-lg font-semibold">{{ venue.address }}</p>
                    <p>{{ venue.city }}, {{ venue.postal }}</p>
                    <p class="text-blue-600 font-medium">NOK {{ venue.price }} / day</p>
                    <p class="text-sm text-gray-400">Owner ID: {{ venue.user_id }}</p>
                </div>
            </div>

            <!-- Description -->
            <p class="text-gray-600">{{ venue.description }}</p>
        </div>

        <!-- Calendar Section -->
        <div class="flex-1 flex flex-col items-center">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800 text-center">Availability</h2>
            <div class="bg-white rounded shadow p-4 w-full max-w-[32rem]">
                <CalendarView class="calendar" @select-range="handleCalendarRangeSelect" />
            </div>
        </div>
    </div>

    <!-- Book Button (Full Width Section Below Content) -->
    <div class="w-full flex justify-center mt-8">
        <button @click="showModal = true"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition">
            Book Now
        </button>
    </div>
    <Teleport to="body">
        <div class="p-6 max-w-2xl mx-auto">
            <BookModal :show="showModal" :venue @close="showModal = false">
                <!-- Modal Header -->
                <template #header>
                    <h1 class="text-2xl font-bold text-gray-800">Book venue: {{ venue.name }}</h1>
                    <p v-if="!dateFrom || !dateTo"
                        class="mt-1 text-sm text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500 p-2 rounded">
                        📅 Please click and drag on the calendar to select a start and end date.
                    </p>

                </template>

                <!-- Modal Body -->
                <template #default>
                    <form id="booking-form" action="/bookings/store" method="POST" enctype="multipart/form-data"
                        class="space-y-6">

                        <!-- Hidden Fields -->
                        <input type="hidden" name="_token" :value="csrf" />
                        <!-- Summary Section -->
                        <div class="bg-gray-100 p-4 rounded">
                            <p class="text-lg font-semibold text-gray-700">Selected Dates:</p>
                            <p class="text-gray-800">From: <span class="font-medium">{{ dateFrom }}</span></p>
                            <p class="text-gray-800">To: <span class="font-medium">{{ dateTo }}</span></p>
                        </div>

                        <!-- Product Selection -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Add Products and Services</h3>
                            <div class="grid gap-4">
                                <div v-for="product in products" :key="product.id"
                                    class="border rounded-md p-4 shadow-sm flex justify-between items-center bg-white hover:shadow-md transition">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-800">{{ product.title }}</h4>
                                        <p class="text-sm text-gray-600 mb-1">Price: NOK {{ product.price }}</p>
                                        <p class="text-sm text-gray-500">{{ product.description }}</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" :value="product.id" v-model="addedProducts"
                                            class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Price -->
                        <div class="text-right">
                            <h3 class="text-xl font-bold text-green-700">Total: NOK {{ totalPrice }}</h3>
                        </div>
                    </form>
                </template>

                <!-- Modal Footer Buttons -->
                <template #footer>
                    <div class="flex justify-end space-x-4">
                        <button @click="showModal = false"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition">
                            Cancel
                        </button>
                        <button @click="bookVenue"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                            Book
                        </button>
                    </div>
                </template>
            </BookModal>
        </div>
    </Teleport>
</template>

<style>
.calendar {
    height: 35rem;
    width: 30rem;
}
</style>