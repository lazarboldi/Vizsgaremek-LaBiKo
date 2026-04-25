import { defineStore } from 'pinia'
import { api } from '@utils/http.mjs'

const filters = [
  { id: 'brand', label: 'Márka szűrés' },
  { id: 'model', label: 'Modell szűrés' },
  { id: 'body', label: 'Kivitel szűrés' },
  { id: 'fuel', label: 'Üzemanyag szűrés' },
  { id: 'year', label: 'Évjárat szűrés' },
  { id: 'price', label: 'Vételár szűrés' }
]

const mapCarFromApi = (car) => ({
  id: car?.id,
  title: `${car?.brand || ''} ${car?.model || ''}`.trim() || 'Ismeretlen autó',
  description: car?.description || '',
  brand: car?.brand || '',
  model: car?.model || '',
  year: car?.year || '',
  price: car?.price || '',
  fuelType: car?.fuel_type || '',
  bodyType: car?.body_type || '',
  mileage: car?.mileage || '',
  transmission: car?.transmission || '',
  engineDetails: car?.engine_size ? `${car.engine_size} cm3` : '',
  image_url: car?.images?.[0]?.image_url || ''
})

export const useListingStore = defineStore('listing', {
  state: () => ({
    activeFilterId: 'brand',
    filters,
    cars: [],
    loading: false,
    errorMessage: ''
  }),
  actions: {
    async getCars() {
      this.loading = true
      this.errorMessage = ''

      try {
        const response = await api.get('cars')
        const fetchedCars = response?.data?.data

        if (!Array.isArray(fetchedCars)) {
          throw new Error('Hibás adatformátum érkezett a szervertől.')
        }

        this.cars = fetchedCars.map(mapCarFromApi)
      } catch (error) {
        this.errorMessage = error.response?.data?.message || error.message || 'Nem sikerült betölteni az autólistát.'
      } finally {
        this.loading = false
      }
    }
  }
})

export const useHomeStore = useListingStore
