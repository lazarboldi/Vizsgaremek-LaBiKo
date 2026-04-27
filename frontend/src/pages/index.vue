<script setup>
import { computed, onMounted, ref, watch } from 'vue'

import BaseCard from '@components/layout/BaseCard.vue'
import BaseLayout from '@layouts/BaseLayout.vue'
import { useListingStore } from '@stores/ListingStore.mjs'
import { useListing } from '@stores/NewListingStore.mjs'
import { useAuthStore } from '@stores/AuthStore.mjs'
import { useFavouritesStore } from '@stores/FavouritesStore.mjs'

const homeStore = useListingStore()
const newListingStore = useListing()
const authStore = useAuthStore()
const favouritesStore = useFavouritesStore()
const selectedFilters = ref({
  brand: '',
  model: '',
  body: '',
  fuel: '',
  year: '',
  price: ''
})
const visibleAdsCount = ref(8)
const activeSortTab = ref('price')
const sortDirection = ref('asc')

const truncateDescription = (text) => {
  const value = String(text || '')

  if (value.length <= 75) {
    return value
  }

  return `${value.slice(0, 72)}...`
}

const parseNumericValue = (value) => {
  const raw = String(value ?? '').trim()

  if (!raw) {
    return Number.POSITIVE_INFINITY
  }

  const normalized = raw
    .replace(/\s+/g, '')
    .replace(',', '.')
  const matched = normalized.match(/\d+(?:\.\d+)?/)
  const numeric = Number(matched?.[0] ?? normalized)

  return Number.isNaN(numeric) ? Number.POSITIVE_INFINITY : numeric
}

// Kombinálja az eredeti autókat és az újonnan létrehozottakat
const allCars = computed(() => {
  const mappedListings = newListingStore.listings.map(listing => ({
    listingId: listing.id,
    id: listing.car?.id || listing.id,
    title: `${listing.car?.brand || ''} ${listing.car?.model || ''}`.trim(),
    description: truncateDescription(listing.car?.description),
    brand: listing.car?.brand || '',
    model: listing.car?.model || '',
    year: listing.car?.year || '',
    price: listing.price || '',
    horsepower: listing.horsepower || listing.horse_power || listing.car?.horsepower || listing.car?.horse_power || listing.car?.power || '',
    fuelType: listing.car?.fuel_type || '',
    bodyType: listing.car?.body_type || '',
    mileage: listing.car?.mileage || '',
    transmission: listing.car?.transmission || '',
    image_url: listing.car?.images?.[0]?.image_url || ''
  }))

  return mappedListings
})

const normalizeFilterOption = value => String(value ?? '').trim()

const buildUniqueFilterOptions = values => [...new Set(
  values
    .map(normalizeFilterOption)
    .filter(Boolean)
)].sort((a, b) => a.localeCompare(b, 'hu', { numeric: true, sensitivity: 'base' }))

const modelOptions = computed(() => {
  const selectedBrand = normalizeFilterOption(selectedFilters.value.brand)

  if (!selectedBrand) {
    return buildUniqueFilterOptions(allCars.value.map(car => car.model))
  }

  return buildUniqueFilterOptions(
    allCars.value
      .filter(car => normalizeFilterOption(car.brand).toLowerCase() === selectedBrand.toLowerCase())
      .map(car => car.model)
  )
})

const filterOptions = computed(() => ({
  brand: buildUniqueFilterOptions(allCars.value.map(car => car.brand)),
  model: modelOptions.value,
  body: buildUniqueFilterOptions(allCars.value.map(car => car.bodyType)),
  fuel: buildUniqueFilterOptions(allCars.value.map(car => car.fuelType)),
  year: buildUniqueFilterOptions(allCars.value.map(car => car.year)),
  price: buildUniqueFilterOptions(allCars.value.map(car => car.price))
}))

const getCarFilterValue = (car, filterId) => {
  switch (filterId) {
    case 'brand':
      return car.brand
    case 'model':
      return car.model
    case 'body':
      return car.bodyType
    case 'fuel':
      return car.fuelType
    case 'year':
      return car.year
    case 'price':
      return car.price
    default:
      return ''
  }
}

const isMaxFilter = filterId => filterId === 'year' || filterId === 'price'

const resetFilters = () => {
  Object.keys(selectedFilters.value).forEach((filterId) => {
    selectedFilters.value[filterId] = ''
  })
}

const filteredCars = computed(() => {
  return allCars.value.filter((car) => {
    return Object.entries(selectedFilters.value).every(([filterId, selectedValue]) => {
      const selected = String(selectedValue || '').trim().toLowerCase()

      if (!selected) {
        return true
      }

      if (isMaxFilter(filterId)) {
        const selectedMax = parseNumericValue(selected)
        const currentNumber = parseNumericValue(getCarFilterValue(car, filterId))

        return currentNumber <= selectedMax
      }

      const currentValue = String(getCarFilterValue(car, filterId) || '').trim().toLowerCase()
      return currentValue === selected
    })
  })
})

const sortedCars = computed(() => {
  const direction = sortDirection.value === 'asc' ? 1 : -1
  const sortByPrice = activeSortTab.value === 'price'

  return [...filteredCars.value].sort((a, b) => {
    const aValue = sortByPrice ? parseNumericValue(a.price) : parseNumericValue(a.mileage)
    const bValue = sortByPrice ? parseNumericValue(b.price) : parseNumericValue(b.mileage)

    if (aValue === bValue) {
      return String(a.title || '').localeCompare(String(b.title || ''))
    }

    return (aValue - bValue) * direction
  })
})

const visibleCars = computed(() => sortedCars.value.slice(0, visibleAdsCount.value))

const canLoadMore = computed(() => sortedCars.value.length > visibleAdsCount.value)

const loadMoreCars = () => {
  visibleAdsCount.value += 8
}

watch(selectedFilters, () => {
  visibleAdsCount.value = 8
}, { deep: true })

watch(() => selectedFilters.value.brand, () => {
  const selectedModel = normalizeFilterOption(selectedFilters.value.model)

  if (selectedModel && !modelOptions.value.includes(selectedModel)) {
    selectedFilters.value.model = ''
  }
})

watch([
  activeSortTab,
  sortDirection
], () => {
  visibleAdsCount.value = 8
})

onMounted(async () => {
  const requests = [
    newListingStore.getListings()
  ]

  if (authStore.isAuthenticated) {
    requests.push(favouritesStore.loadFavourites())
  }

  await Promise.all(requests)
})
</script>

<template>
  <BaseLayout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 text-slate-800">
      <main class="mx-auto grid max-w-[1320px] grid-cols-1 gap-6 px-4 pt-6 pb-10 md:px-6 lg:grid-cols-[280px_minmax(0,1fr)] lg:pt-9 lg:pb-12">
        <aside
          class="w-full self-start overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg"
          aria-label="Szűrési panel"
        >
          <h2 class="m-0 border-b border-slate-200 px-5 py-5 text-4xl leading-tight font-extrabold max-sm:text-3xl">
            Szűrés
          </h2>
          <div class="space-y-3 px-4 py-4">
            <label
              v-for="filter in homeStore.filters"
              :key="filter.id"
              class="block"
            >
              <span class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-500">{{ filter.label }}</span>
              <input
                v-if="filter.id === 'year' || filter.id === 'price'"
                v-model="selectedFilters[filter.id]"
                type="text"
                inputmode="numeric"
                :placeholder="filter.id === 'year' ? 'Pl.: 2018 (max)' : 'Pl.: 6500000 (max)'"
                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
              />
              <select
                v-else
                v-model="selectedFilters[filter.id]"
                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
              >
                <option value="">Összes</option>
                <option
                  v-for="option in filterOptions[filter.id] || []"
                  :key="`${filter.id}-${option}`"
                  :value="option"
                >
                  {{ option }}
                </option>
              </select>
            </label>
            <button
              type="button"
              class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition hover:border-orange-500 hover:text-orange-600"
              @click="resetFilters"
            >
              Szűrők törlése
            </button>
          </div>
        </aside>
        <section aria-label="Autók listázása">
          <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
            <div>
              <h1 class="m-0 text-[clamp(2rem,2.5vw,3rem)] font-extrabold text-slate-800">Autókereskedés</h1>
              <p class="mt-1 text-xl font-semibold text-slate-500 max-sm:text-lg">
                Válogasson kínálatunkból!
              </p>
            </div>
            <div class="w-full max-w-[360px] rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
              <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <label class="block">
                  <span class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-500">Rendezés</span>
                  <select
                    v-model="activeSortTab"
                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                  >
                    <option value="price">Vételár</option>
                    <option value="mileage">Kilométer</option>
                  </select>
                </label>
                <label class="block">
                  <span class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-500">Sorrend</span>
                  <select
                    v-model="sortDirection"
                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                  >
                    <option value="asc">Növekvő</option>
                    <option value="desc">Csökkenő</option>
                  </select>
                </label>
              </div>
            </div>
          </div>
          <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">
            <BaseCard v-for="car in visibleCars" :key="`${car.listingId || 'car'}-${car.id}`" :car="car" />
          </div>
          <div v-if="canLoadMore" class="mt-6 flex justify-center">
            <button
              type="button"
              class="rounded-lg border border-orange-500 bg-orange-500 px-6 py-3 text-base font-bold text-white transition hover:bg-orange-600"
              @click="loadMoreCars"
            >
              Több mutatása
            </button>
          </div>
          <p v-if="sortedCars.length === 0" class="mt-4 text-base font-semibold text-slate-500">
            Nincs találat a megadott szűrőfeltételre.
          </p>
        </section>
      </main>
    </div>
  </BaseLayout>
</template>

<route lang="yaml">
name: index
meta:
  title: Főoldal
</route>
