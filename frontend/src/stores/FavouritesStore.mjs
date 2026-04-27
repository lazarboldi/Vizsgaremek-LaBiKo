import { defineStore } from 'pinia'
import { computed, ref } from 'vue'
import { useAuthStore } from '@stores/AuthStore.mjs'
import { api } from '@utils/http.mjs'

export const useFavouritesStore = defineStore('favourites', () => {
  const listings = ref([])
  const loading = ref(false)
  const errorMessage = ref('')

  const favouriteListingIds = computed(() => listings.value.map(item => Number(item.id)).filter(Number.isFinite))

  const authHeaders = (token) => ({
    Authorization: `Bearer ${token}`
  })

  const isFavourite = (listingId) => favouriteListingIds.value.includes(Number(listingId))

  const loadFavourites = async () => {
    const authStore = useAuthStore()

    if (!authStore.isAuthenticated || !authStore.token) {
      listings.value = []
      return
    }

    loading.value = true
    errorMessage.value = ''

    try {
      const response = await api.get('favourites', {
        headers: authHeaders(authStore.token)
      })

      const fetched = response?.data?.data
      listings.value = Array.isArray(fetched) ? fetched : []
    } catch (error) {
      errorMessage.value = error.response?.data?.message || 'Nem sikerült betölteni a gyűjteményt.'
    } finally {
      loading.value = false
    }
  }

  const addFavourite = async (listingId) => {
    const authStore = useAuthStore()

    if (!authStore.isAuthenticated || !authStore.token) {
      throw new Error('A gyűjtemény használatához be kell jelentkezned.')
    }

    await api.post(`favourites/${listingId}`, {}, {
      headers: authHeaders(authStore.token)
    })

    await loadFavourites()
  }

  const removeFavourite = async (listingId) => {
    const authStore = useAuthStore()

    if (!authStore.isAuthenticated || !authStore.token) {
      throw new Error('A gyűjtemény használatához be kell jelentkezned.')
    }

    await api.delete(`favourites/${listingId}`, {
      headers: authHeaders(authStore.token)
    })

    listings.value = listings.value.filter(item => Number(item.id) !== Number(listingId))
  }

  const toggleFavourite = async (listingId) => {
    if (isFavourite(listingId)) {
      await removeFavourite(listingId)
      return false
    }

    await addFavourite(listingId)
    return true
  }

  return {
    listings,
    loading,
    errorMessage,
    favouriteListingIds,
    isFavourite,
    loadFavourites,
    addFavourite,
    removeFavourite,
    toggleFavourite
  }
})
