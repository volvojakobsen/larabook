import { createApp } from 'vue'
import VenueContainer from './components/VenueContainer.vue'
import Venue from './components/Venue.vue'
import MyVenues from './components/My-Venues.vue'
import ListProducts from './components/List-Products.vue'
import UserBookings from './components/UserBookings.vue'
// import BookModal from './components/BookModal.vue'
import VueTailwindDatepicker from "vue-tailwind-datepicker"
import './bootstrap'

import Vue3Toastify from 'vue3-toastify'
import 'vue3-toastify/dist/index.css' // Required styles for toast


// Create app
const app = createApp({})

// Register global components
app.component('VenueContainer', VenueContainer)
app.component('UserBookings', UserBookings)
app.component('Venue', Venue)
app.component('MyVenues', MyVenues)
app.component('ListProducts', ListProducts)
app.component('VueTailwindDatepicker', VueTailwindDatepicker)
// app.component('BookModal', BookModal)

// ✅ Register toast plugin correctly
app.use(Vue3Toastify, {
  autoClose: 3000,
  position: "top-right",
})

// Mount app
app.mount('#app')