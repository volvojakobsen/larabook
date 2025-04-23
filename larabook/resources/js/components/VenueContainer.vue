<script setup>
import { onMounted, ref } from 'vue';
import axios from "axios";
import { TailwindPagination } from 'laravel-vue-pagination';

const venues = ref([]);



const getVenues = (page = 1) => {
  axios.get(`/venue/getList?page=${page}`)
    .then(res => venues.value = res.data)
    .catch(error => console.log(error))
}

// const getVenues = async (page = 1) => {
//     const response = await fetch(`/venue/getList?page=${page}`);
//     venues.value = await response.json();
// }

onMounted(() => getVenues());

</script>

<template>
  <div class="flex gap-3 justify-center">
    <div v-for="venue in venues.data" class="w-96 h-96 border border-sky-500 shadow-lg rounded-xl bg-white">
      <a :href="'/venue/' + venue.id + '?id=' + venue.id + '&userId=' + venue.user_id">
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
  <div class="flex justify-center mt-6">
    <TailwindPagination
        :data="venues"
        @pagination-change-page="getVenues"
    />
  </div>
</template>