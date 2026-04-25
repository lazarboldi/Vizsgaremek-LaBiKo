<script setup>
import {
  ChevronRight,
} from 'lucide-vue-next'
import { computed, onMounted, ref } from 'vue'

import BaseCard from '@components/layout/BaseCard.vue'
import BaseHeader from '@components/layout/BaseHeader.vue'
import { useListingStore } from '@stores/ListingStore.mjs'
import { useListing } from '@stores/NewListingStore.mjs'

const homeStore = useListingStore()
const newListingStore = useListing()
const filterValue = ref('')

// Kombinálja az eredeti autókat és az újonnan létrehozottakat
const allCars = computed(() => {
  const mappedListings = newListingStore.listings.map(listing => ({
    listingId: listing.id,
    id: listing.car?.id || listing.id,
    title: `${listing.car?.brand || ''} ${listing.car?.model || ''}`.trim(),
    description: listing.car?.description || '',
    brand: listing.car?.brand || '',
    model: listing.car?.model || '',
    year: listing.car?.year || '',
    price: listing.price || '',
    fuelType: listing.car?.fuel_type || '',
    bodyType: listing.car?.body_type || '',
    mileage: listing.car?.mileage || '',
    transmission: listing.car?.transmission || '',
    image_url: listing.car?.images?.[0]?.image_url || ''
  }))

  const mappedCars = homeStore.cars.map(car => {
    const relatedListing = newListingStore.listings.find(listing => String(listing.car?.id) === String(car.id))

    return {
      ...car,
      listingId: relatedListing?.id || null
    }
  }).filter(car => !car.listingId)

  return [...mappedCars, ...mappedListings]
})

const activeFilterLabel = computed(() => {
  const activeFilter = homeStore.filters.find(filter => filter.id === homeStore.activeFilterId)
  return activeFilter?.label || 'Szűrés'
})

const filteredCars = computed(() => {
  const query = filterValue.value.trim().toLowerCase()

  if (!query) {
    return allCars.value
  }

  return allCars.value.filter((car) => {
    switch (homeStore.activeFilterId) {
      case 'brand':
        return (car.brand || '').toLowerCase().includes(query)
      case 'model':
        return (car.model || '').toLowerCase().includes(query)
      case 'body':
        return (car.bodyType || '').toLowerCase().includes(query)
      case 'fuel':
        return (car.fuelType || '').toLowerCase().includes(query)
      case 'year':
        return String(car.year || '').includes(query)
      case 'price': {
        const maxPrice = Number(query)
        if (Number.isNaN(maxPrice)) {
          return true
        }
        return Number(car.price || 0) <= maxPrice
      }
      default:
        return true
    }
  })
})

onMounted(async () => {
  await Promise.all([
    homeStore.getCars(),
    newListingStore.getListings()
  ])
})
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 text-slate-800">
    <BaseHeader />

    <main class="mx-auto grid max-w-[1320px] grid-cols-1 gap-6 px-4 pt-6 pb-10 md:px-6 lg:grid-cols-[280px_minmax(0,1fr)] lg:pt-9 lg:pb-12">
      <aside
        class="w-full self-start overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg"
        aria-label="Szűrési panel"
      >
        <h2 class="m-0 border-b border-slate-200 px-5 py-5 text-4xl leading-tight font-extrabold max-sm:text-3xl">
          Szűrés
        </h2>
        <ul class="m-0 list-none p-2.5">
          <li v-for="filter in homeStore.filters" :key="filter.id" class="not-last:mb-1">
            <button
              type="button"
              :class="[
                'flex w-full items-center justify-between rounded-lg border-0 bg-transparent px-3 py-3.5 text-slate-600 transition-all duration-200 hover:bg-slate-100',
                homeStore.activeFilterId === filter.id
                  ? 'rounded-l-none border-l-[3px] border-l-orange-500 bg-slate-50 text-slate-900'
                  : ''
              ]"
              @click="homeStore.activeFilterId = filter.id"
            >
              <span class="inline-flex items-center gap-[0.7rem]">
                <span class="text-[1.02rem] font-bold">{{ filter.label }}</span>
              </span>
              <ChevronRight :size="18" class="text-slate-400" />
            </button>
          </li>
        </ul>

        <div class="px-4 pb-4">
          <input
            v-model="filterValue"
            type="text"
            :placeholder="`${activeFilterLabel}...`"
            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
          />
        </div>
      </aside>

      <section aria-label="Autók listázása">
        <h1 class="m-0 text-[clamp(2rem,2.5vw,3rem)] font-extrabold text-slate-800">Autókereskedés</h1>
        <p class="mt-1 mb-6 text-xl font-semibold text-slate-500 max-sm:text-lg">
          Válogasson kínálatunkból!
        </p>

        <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">
          <BaseCard v-for="car in filteredCars" :key="`${car.listingId || 'car'}-${car.id}`" :car="car" />
        </div>

        <p v-if="filteredCars.length === 0" class="mt-4 text-base font-semibold text-slate-500">
          Nincs találat a megadott szűrőfeltételre.
        </p>
      </section>
    </main>
  </div>
</template>

<route lang="yaml">
name: index
meta:
  title: Főoldal
</route>
