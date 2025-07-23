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
  <div class="flex flex-wrap gap-6 justify-center p-6 bg-gray-50">
    <div 
      v-for="product in products" 
      :key="product.id"
      class="w-72 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-200 border border-gray-200"
    >
      <a 
        :href="'/products/edit/' + product.id + '?id=' + product.id"
        class="block p-3"
      >
        <!-- Title -->
        <h3 class="text-lg font-semibold text-gray-800 text-center truncate">
          {{ product.title }}
        </h3>

        <!-- Price -->
        <div class="text-center text-sm text-sky-600 font-medium my-1">
          {{ product.price }} NOK
        </div>

        <!-- Description -->
        <p class="text-xs text-gray-600 line-clamp-3 mt-2">
          {{ product.description }}
        </p>
      </a>
    </div>
  </div>
</template>

