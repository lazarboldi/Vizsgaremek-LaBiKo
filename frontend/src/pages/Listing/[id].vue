<script setup>
import { computed, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'

import BaseHeader from '@components/layout/BaseHeader.vue'
import { useListing } from '@stores/NewListingStore.mjs'
import carBlueImage from '@assets/images/home/car-blue.jpg'

const route = useRoute()
const listingStore = useListing()

const loading = ref(true)
const errorMessage = ref('')
const listing = ref(null)
const selectedPhoto = ref('')

const backendOrigin = import.meta.env.VITE_BACKEND_URL?.replace(/\/api\/?$/, '/')

const resolveImageUrl = (url) => {
  if (!url || typeof url !== 'string') {
    return carBlueImage
  }

  const normalized = url.trim()

  if (!normalized) {
    return carBlueImage
  }

  if (/^https?:\/\//i.test(normalized)) {
    return normalized
  }

  if (!backendOrigin) {
    return normalized
  }

  return new URL(normalized, backendOrigin).toString()
}

const listingId = computed(() => String(route.params.id || ''))

const photos = computed(() => {
  const images = listing.value?.car?.images || []

  if (!images.length) {
    return [carBlueImage]
  }

  return images
    .map(image => resolveImageUrl(image?.image_url))
    .filter(Boolean)
})

const coverPhoto = computed(() => selectedPhoto.value || photos.value[0] || carBlueImage)

const listingTitle = computed(() => {
  const brand = listing.value?.car?.brand || ''
  const model = listing.value?.car?.model || ''
  return `${brand} ${model}`.trim() || 'Hirdetés részletei'
})

const formatPrice = (value) => {
  const numeric = Number(value)

  if (Number.isNaN(numeric)) {
    return 'Nincs megadva'
  }

  return `${new Intl.NumberFormat('hu-HU').format(numeric)} Ft`
}

const formatMileage = (value) => {
  const numeric = Number(value)

  if (Number.isNaN(numeric)) {
    return 'Nincs megadva'
  }

  return `${new Intl.NumberFormat('hu-HU').format(numeric)} km`
}

onMounted(async () => {
  loading.value = true
  errorMessage.value = ''

  try {
    if (!listingId.value) {
      throw new Error('Hiányzó hirdetés azonosító.')
    }

    const found = await listingStore.getListingById(listingId.value)

    if (!found) {
      throw new Error('A hirdetés nem található.')
    }

    listing.value = found
    selectedPhoto.value = photos.value[0] || ''
  } catch (error) {
    errorMessage.value = error.response?.data?.message || error.message || 'Nem sikerült betölteni a hirdetést.'
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 text-slate-800">
    <BaseHeader />

    <main class="mx-auto max-w-[1320px] px-4 pt-6 pb-10 md:px-6">
      <RouterLink
        to="/"
        class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 no-underline shadow-sm hover:bg-slate-50"
      >
        ← Vissza a listához
      </RouterLink>

      <section v-if="loading" class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-lg">
        Betöltés...
      </section>

      <section v-else-if="errorMessage" class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-6 text-red-700 shadow-lg">
        {{ errorMessage }}
      </section>

      <section v-else-if="listing" class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-[1.2fr_minmax(0,1fr)]">
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-lg">
          <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
            <img
              :src="coverPhoto"
              :alt="listingTitle"
              class="block h-[320px] w-full object-cover md:h-[420px]"
            />
          </div>

          <div v-if="photos.length > 1" class="mt-4 grid grid-cols-3 gap-2 sm:grid-cols-4">
            <button
              v-for="(photo, index) in photos"
              :key="`${photo}-${index}`"
              type="button"
              class="overflow-hidden rounded-lg border-2 transition"
              :class="photo === coverPhoto ? 'border-orange-500' : 'border-slate-200 hover:border-slate-300'"
              @click="selectedPhoto = photo"
            >
              <img
                :src="photo"
                :alt="`${listingTitle} ${index + 1}`"
                class="h-20 w-full object-cover"
              />
            </button>
          </div>
        </article>

        <article class="space-y-6">
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg">
            <p class="m-0 text-sm font-semibold uppercase tracking-wide text-orange-500">Hirdetés</p>
            <h1 class="mt-2 text-[clamp(1.8rem,3vw,2.5rem)] leading-tight font-extrabold text-slate-900">
              {{ listingTitle }}
            </h1>
            <p class="mt-3 text-3xl font-extrabold text-slate-900">{{ formatPrice(listing.price) }}</p>

            <dl class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2">
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Évjárat</dt>
                <dd class="mt-1 text-base font-semibold text-slate-800">{{ listing.car?.year || 'Nincs megadva' }}</dd>
              </div>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Futott táv</dt>
                <dd class="mt-1 text-base font-semibold text-slate-800">{{ formatMileage(listing.car?.mileage)}}</dd>
              </div>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Üzemanyag</dt>
                <dd class="mt-1 text-base font-semibold text-slate-800">{{ listing.car?.fuel_type || 'Nincs megadva' }}</dd>
              </div>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Váltó</dt>
                <dd class="mt-1 text-base font-semibold text-slate-800">{{ listing.car?.transmission || 'Nincs megadva' }}</dd>
              </div>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Motor térfogat</dt>
                <dd class="mt-1 text-base font-semibold text-slate-800">{{ listing.car?.engine_size || 'Nincs megadva' }}{{ listing.car?.engine_size ? ' cm³' : '' }}</dd>
              </div>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Karosszéria</dt>
                <dd class="mt-1 text-base font-semibold text-slate-800">{{ listing.car?.body_type || 'Nincs megadva' }}</dd>
              </div>
            </dl>
          </div>

          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg">
            <h2 class="m-0 text-xl font-bold text-slate-900">Leírás</h2>
            <p class="mt-3 text-base leading-relaxed text-slate-600">
              {{ listing.car?.description || 'Ehhez a hirdetéshez még nincs leírás.' }}
            </p>
          </div>

          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg">
            <h2 class="m-0 text-xl font-bold text-slate-900">Eladó</h2>
            <p class="mt-3 text-base text-slate-700"><span class="font-semibold">Név:</span> {{ listing.user?.name || 'Nincs megadva' }}</p>
            <p class="mt-1 text-base text-slate-700"><span class="font-semibold">Email:</span> {{ listing.user?.email || 'Nincs megadva' }}</p>
            <p class="mt-1 text-base text-slate-700"><span class="font-semibold">Telefon:</span> {{ listing.user?.phone || 'Nincs megadva' }}</p>
          </div>
        </article>
      </section>
    </main>
  </div>
</template>

<route lang="yaml">
name: listing.detail
path: /listing/:id
meta:
  title: Hirdetés részletei
</route>
