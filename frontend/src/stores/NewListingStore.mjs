import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { api } from '@utils/http.mjs'

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
    // Először egy autót hozunk létre
    const carResponse = await api.post('cars', {
      make: data.brand,
      model: data.model,
      description: data.description,
      year: data.year,
      mileage: data.mileage,
      fuel_type: data.fuelType,
      transmission: data.transmission
    })

    const carId = carResponse.data.data.id

    // Majd létrehozunk egy Listing-et a car_idval
    const response = await api.post('listings', {
      car_id: carId,
      price: data.price,
      status: 'active'
    })

    const newListing = response.data.data
    listings.value.push(newListing)
    saveListingsToStorage(listings.value)
    return newListing
  }

  return { listings, getListings, createListing }
})
