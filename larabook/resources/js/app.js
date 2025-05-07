import { createApp } from 'vue';
import VenueContainer from './components/VenueContainer.vue';
import Venue from './components/Venue.vue';
import MyVenues from './components/My-Venues.vue';
import ListProducts from './components/List-Products.vue';
//import BookModal from './components/BookModal.vue';
import VueTailwindDatepicker from "vue-tailwind-datepicker";
import './bootstrap';
import axios from 'axios';

axios.defaults.headers.common['X-CSRF-TOKEN'] = document
  .querySelector('meta[name="csrf-token"]')
  .getAttribute('content');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';





createApp({})
  .component('VenueContainer', VenueContainer)
  .component('Venue', Venue)
  .component('MyVenues', MyVenues)
  .component('ListProducts', ListProducts)
  .component('VueTailwindDatepicker', VueTailwindDatepicker)
  //.component('BookModal', BookModal)
  .mount('#app')
