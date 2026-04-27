<script setup>
import { computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'

import BaseCard from '@components/layout/BaseCard.vue'
import BaseLayout from '@layouts/BaseLayout.vue'
import { useAuthStore } from '@stores/AuthStore.mjs'
import { useFavouritesStore } from '@stores/FavouritesStore.mjs'

const router = useRouter()
const authStore = useAuthStore()
const favouritesStore = useFavouritesStore()

const truncateDescription = (text) => {
  const value = String(text || '')

  if (value.length <= 75) {
    return value
  }

  return `${value.slice(0, 72)}...`
}

const favouriteCars = computed(() => {
  return favouritesStore.listings.map(listing => ({
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
})

onMounted(async () => {
  if (!authStore.isAuthenticated) {
    await router.replace('/auth/login?redirect=/collection')
    return
  }

  await favouritesStore.loadFavourites()
})
</script>

<template>
  <BaseLayout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 text-slate-800">
      <main class="mx-auto max-w-[1320px] px-4 pt-6 pb-10 md:px-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
          <h1 class="m-0 text-[clamp(1.8rem,2.4vw,2.8rem)] font-extrabold text-slate-800">Gyűjtemény</h1>
          <p class="mt-2 mb-6 text-slate-600">Itt találod az általad elmentett hirdetéseket.</p>

          <p v-if="favouritesStore.errorMessage" class="mb-5 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700">
            {{ favouritesStore.errorMessage }}
          </p>

          <div v-if="favouritesStore.loading" class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-600">
            Gyűjtemény betöltése...
          </div>

          <div v-else-if="favouriteCars.length === 0" class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-600">
            Még nincs mentett hirdetésed.
          </div>

          <div v-else class="grid grid-cols-1 gap-5 xl:grid-cols-2">
            <BaseCard
              v-for="car in favouriteCars"
              :key="`collection-${car.listingId || car.id}`"
              :car="car"
            />
          </div>
        </section>
      </main>
    </div>
  </BaseLayout>
</template>

<route lang="yaml">
name: collection
path: /collection
meta:
  title: Gyűjtemény
</route>
