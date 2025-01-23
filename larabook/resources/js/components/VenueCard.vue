<script setup>
import { onMounted, ref} from 'vue';

const venues = ref([])

async function getVenues() {
    await fetch("/venue/getList")
  .then((response) => response.json())
  .then((json) => venues.value = json);
}
onMounted(getVenues());
console.log(venues)
</script>

<template>
<div v-for="venue in venues" class="">
  <div class="w-1 gap-8 border mb-6">
    <h3>{{ venue.image }}</h3>
    <img :src="venue.image">
  </div>
    
</div>
</template>

