<script setup>
import { onMounted, ref } from 'vue';
import axios from "axios";
import { TailwindPagination } from 'laravel-vue-pagination';

const venues = ref([]);



const sortField = ref('created_at');
const sortDirection = ref('asc');
const search = ref('');

const getVenues = (page = 1) => {
  axios.get(`/venue/getList`, {
    params: {
      page,
      sortField: sortField.value,
      sortDirection: sortDirection.value,
      search: search.value
    }
  })
  .then(res => venues.value = res.data)
  .catch(error => console.log(error));
}

const changeSorting = () => getVenues();
const submitSearch = () => getVenues();


onMounted(() => getVenues());

</script>

<template>
  <div class="flex justify-between flex-wrap gap-2 items-center mb-4 px-2">
  <!-- Search input -->
  <input
    v-model="search"
    @keyup.enter="submitSearch"
    type="text"
    placeholder="Search venues..."
    class="border px-3 py-1 rounded w-1/2 max-w-md"
  />

  <!-- Sorting options -->
  <div class="flex gap-2">
    <select v-model="sortField" @change="changeSorting" class="appearance-none border px-2 py-1 pr-6 rounded bg-white bg-no-repeat bg-right">
      <option value="name">Name</option>
      <option value="price">Price</option>
      <option value="created_at">Created At</option>
    </select>

    <select v-model="sortDirection" @change="changeSorting" class="appearance-none border px-2 py-1 pr-6 rounded bg-white bg-no-repeat bg-right">
      <option value="asc">Ascending</option>
      <option value="desc">Descending</option>
    </select>
  </div>
</div>


  <div class="flex gap-3 flex-wrap justify-center">
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