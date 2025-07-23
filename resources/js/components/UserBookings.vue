<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const bookings = ref([])
const loading = ref(true)

// Format date like "22 April 2025"
function formatDate(dateStr) {
  if (!dateStr) return ''
  const date = new Date(dateStr)
  return new Intl.DateTimeFormat('en-GB', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  }).format(date)
}

onMounted(async () => {
  try {
    const response = await axios.get('/myBookings/getUsersBookings')
    const fetchedBookings = response.data

    const bookingsWithDetails = await Promise.all(
      fetchedBookings.map(async (booking) => {
        let products = []
        let venue = {}

        try {
          const productResponse = await axios.get(`/myBookings/getUsersBookedProducts/${booking.id}`)
          products = productResponse.data
        } catch (err) {
          console.error(`Failed to fetch products for booking ${booking.id}`, err)
        }

        try {
          const venueResponse = await axios.get(`/venueRequest/${booking.venue_id}`)
          venue = venueResponse.data
        } catch (err) {
          console.error(`Failed to fetch venue ${booking.venue_id}`, err)
        }

        return {
          ...booking,
          products,
          venueTitle: venue.name || `Venue #${booking.venue_id}`
        }
      })
    )

    bookings.value = bookingsWithDetails
  } catch (error) {
    console.error('Error fetching bookings:', error)
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div>
    <div v-if="loading" class="text-gray-600">Loading bookings...</div>
    <div v-else-if="bookings.length === 0" class="text-gray-500">No bookings found.</div>

    <div v-else class="flex flex-wrap gap-4">
      <div
        v-for="booking in bookings"
        :key="booking.id"
        class="w-full sm:w-[48%] md:w-[31%] lg:w-[23%] border border-gray-200 rounded-lg shadow-sm p-3 bg-white"
      >
        <h3 class="text-lg font-bold text-gray-800 mb-1">#{{ booking.venueTitle }}</h3>
        <p class="text-sm text-gray-600"><span class="font-medium">Venue:</span> {{ booking.venueTitle }}</p>
        <p class="text-sm text-gray-600">{{ formatDate(booking.dateFrom) }} → {{ formatDate(booking.dateTo) }}</p>
        <p class="text-sm text-green-700 font-semibold mt-1">Total NOK {{ booking.totalPrice }}</p>

        <div v-if="booking.products.length" class="mt-3 border-t pt-2">
          <p class="text-sm font-semibold text-gray-700 mb-1">Products:</p>
          <ul class="text-sm text-gray-600 list-disc list-inside space-y-1">
            <li v-for="product in booking.products" :key="product.id">
              {{ product.title }} - NOK {{ product.price }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>