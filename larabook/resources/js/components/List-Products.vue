<script setup>
import { onMounted, ref } from 'vue';
import axios from "axios";

const products = ref([]);

const getProducts = () => {
  axios.get('/products/index')
    .then(res => products.value = res.data)
    .catch(error => console.log(error))
}

onMounted(() => getProducts());
console.log(products);

</script>

<template>
  <div class="flex flex-wrap gap-3 justify-center">
    <div v-for="product in products" class="w-96 h-96 border border-sky-500 shadow-lg rounded-xl bg-white">
      <a :href="'/products/edit/' + product.id + '?id=' + product.id">
        <h3 class="text-center m-1">{{ product.title }}</h3>
        <div class="flex justify-between mt-1">
          <h4 class="ml-8">{{ product.price }} NOK</h4>
        </div>
        <p class="mt-3">{{ product.description }}</p>
      </a>

    </div>


  </div>
</template>