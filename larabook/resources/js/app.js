import { createApp } from 'vue';
import VenueContainer from './components/VenueContainer.vue';

 
createApp({})
  .component('VenueContainer', VenueContainer)
  .mount('#app')