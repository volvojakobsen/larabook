import { createApp } from 'vue';
import VenueContainer from './components/VenueContainer.vue';
import Venue from './components/Venue.vue';
import MyVenues from './components/My-Venues.vue';
 
createApp({})
  .component('VenueContainer', VenueContainer)
  .component('Venue', Venue)
  .component('MyVenues', MyVenues)
  .mount('#app')