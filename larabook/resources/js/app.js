import { createApp } from 'vue';
import VenueContainer from './components/VenueContainer.vue';
import Venue from './components/Venue.vue';
import MyVenues from './components/My-Venues.vue';
import ListProducts from './components/List-Products.vue';
//import BookModal from './components/BookModal.vue';
import './bootstrap';



createApp({})
  .component('VenueContainer', VenueContainer)
  .component('Venue', Venue)
  .component('MyVenues', MyVenues)
  .component('ListProducts', ListProducts)
  //.component('BookModal', BookModal)
  .mount('#app')
