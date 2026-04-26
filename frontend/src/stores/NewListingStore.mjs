import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { api } from '@utils/http.mjs'
import { useAuthStore } from '@stores/AuthStore.mjs'

const LISTINGS_STORAGE_KEY = 'listings_data'

// betölti a hirdetéseket a localstorageból
const loadListingsFromStorage = () => {
  const stored = localStorage.getItem(LISTINGS_STORAGE_KEY)
  return stored ? JSON.parse(stored) : []
}

// Ment a localstorageba
const saveListingsToStorage = (listings) => {
  localStorage.setItem(LISTINGS_STORAGE_KEY, JSON.stringify(listings))
}

export const useListing = defineStore('listings', () => {
  const listings = ref(loadListingsFromStorage())

  async function getListings() {
    const response = await api.get('listings')
    listings.value = response.data.data || []
    saveListingsToStorage(listings.value)
  }

  async function createListing(data) {
    const authStore = useAuthStore()
    const token = authStore.token

    if (!token) {
      throw new Error('A hirdetés létrehozásához be kell jelentkezned.')
    }

    const authHeaders = {
      Authorization: `Bearer ${token}`
    }

    // Először egy autót hozunk létre
    const carResponse = await api.post('cars', {
      brand: data.brand,
      model: data.model,
      description: data.description,
      year: data.year,
      mileage: data.mileage,
      fuel_type: data.fuelType,
      transmission: data.transmission,
      color: data.color,
      engine_size: data.engineSize,
      body_type: data.bodyType
    }, {
      headers: authHeaders
    })

    const carId = carResponse?.data?.data?.id

    if (!carId) {
      throw new Error('Nem sikerült létrehozni az autó adatait.')
    }

    // ha vannak képek, feltöltjük őket
    if (data.images && data.images.length > 0) {
      for (const image of data.images) {
        const formData = new FormData()
        formData.append('image', image)
        formData.append('car_id', carId)
        
        await api.post('carimages', formData, {
          headers: {
            ...authHeaders
          }
        })
      }
    }

    // Majd létrehozunk egy Listing-et a car_idval
    const response = await api.post('listings', {
      car_id: carId,
      price: data.price,
      horsepower: data.horsepower,
      status: 'active'
    }, {
      headers: authHeaders
    })

    const newListing = response.data.data
    listings.value.push(newListing)
    saveListingsToStorage(listings.value)
    return newListing
  }

  async function getListingById(id) {
    const localListing = listings.value.find(listing => String(listing.id) === String(id))

    if (localListing) {
      return localListing
    }

    const response = await api.get(`listings/${id}`)
    const listing = response?.data?.data || response?.data || null

    if (listing) {
      const existingIndex = listings.value.findIndex(item => String(item.id) === String(listing.id))

      if (existingIndex >= 0) {
        listings.value[existingIndex] = listing
      } else {
        listings.value.push(listing)
      }

      saveListingsToStorage(listings.value)
    }

    return listing
  }

  return { listings, getListings, createListing, getListingById }
})
