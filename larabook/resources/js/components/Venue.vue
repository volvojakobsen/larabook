<script setup>
import { onMounted, ref } from 'vue';
import axios from "axios";

 const venue = ref([]);
 

 const url = new URL(window.location.href);
 const queryParams = new URLSearchParams(url.search);

const getVenue = () => {
  axios.get('/venueRequest/' + queryParams.get('id'))
    .then(res => venue.value = res.data)
    .catch(error => console.log(error))
}


onMounted(() => getVenue());


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
</template>