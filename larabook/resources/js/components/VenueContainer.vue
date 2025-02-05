<script setup>
import { onMounted, ref } from 'vue';
import axios from "axios";

const venues = ref([]);

const getVenues = () => {
  axios.get('/venue/getList')
    .then(res => venues.value = res.data)
    .catch(error => console.log(error))
}

onMounted(() => getVenues());

</script>

<template>
  <div class="flex flex-wrap gap-3 justify-center">
    <div v-for="venue in venues" class="w-96 h-96 border border-sky-500 shadow-lg rounded-xl bg-white">
      <a :href="'/venue/show/' + venue.id">
        <h3 class="text-center m-1">{{ venue.name }}</h3>
        <img :src="venue.image" class="object-cover h-48 w-96">
        <div class="flex justify-between mt-1">
          <h4 class="ml-8">{{ venue.price }} NOK</h4>
          <h4 class="mr-4">{{ venue.city }}</h4>
        </div>
        <p class="mt-3">{{ venue.description }}</p>
      </a>

    </div>


  </div>
</template>