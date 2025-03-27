<script setup>
import { onMounted, ref } from 'vue';
import axios from "axios";
import BookModal from './BookModal.vue';

const venue = ref([]);


const url = new URL(window.location.href);
const queryParams = new URLSearchParams(url.search);

const getVenue = () => {
    axios.get('/venueRequest/' + queryParams.get('id'))
        .then(res => venue.value = res.data)
        .catch(error => console.log(error))
}


onMounted(() => getVenue());

let showModal = ref(false);


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
                <form id="booking-form" action="http://larabook.test/bookings/store" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <meta name="csrf-token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="_method" value="POST" />
                    <label for="dateFrom">From Date</label>
                    <input name="dateFrom" id="dateFrom" type="date"/>
                    <label for="dateTo">To Date</label>
                    <input name="dateTo" id="dateTo" type="date"/>
                    <input type="number" name="venue_id" value="{{ venue.id }}"  />
                    <input type="number" name="totalPrice" value="{{ venue.price }}"  />
                    <h1>venue id: {{ venue.id }}</h1>
                    <h1>venue price: {{ venue.price }}</h1>

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