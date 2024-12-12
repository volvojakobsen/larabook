import { createApp } from 'vue';
import IncrementCounter from './components/IncrementCounter.vue';
import VenueContainer from './components/VenueContainer.vue';
 
createApp({})
  .component('VenueContainer', VenueContainer)
  .mount('#app')