<script setup>
import { onMounted, ref } from 'vue';

const venues = ref([])

async function getVenues() {
  await fetch("/venue/getList")
    .then((response) => response.json())
    .then((json) => venues.value = json);
}
onMounted(getVenues());
//console.log(venues)
</script>

<template>
  <div class="flex gap-3 justify-center">
    <div v-for="venue in venues" class="w-96 h-96 border border-sky-500 shadow-lg rounded-xl bg-white">
      <h3 class="text-center m-1">{{ venue.name }}</h3>
      <img :src="venue.image" class="object-cover h-48 w-96">
      <div class="flex justify-between">
        <h4 class="ml-8">{{ venue.price }} NOK</h4>
        <h4 class="mr-4">{{ venue.city }}</h4>
      </div>
      <p class="mt-3">{{ venue.description }}</p>
    </div>


  </div>
</template>