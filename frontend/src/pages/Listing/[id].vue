<script setup>
import { computed, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import lightbox from 'lightbox2'
import 'lightbox2/dist/css/lightbox.css'

import BaseLayout from '@layouts/BaseLayout.vue'
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

const sellerEmail = computed(() => (listing.value?.user?.email || '').trim())
const sellerPhone = computed(() => (listing.value?.user?.phone || '').trim())

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

const formatHorsepower = (value) => {
  const numeric = Number(value)

  if (Number.isNaN(numeric)) {
    return 'Nincs megadva'
  }

  return `${new Intl.NumberFormat('hu-HU').format(numeric)} LE`
}

onMounted(async () => {
  lightbox.option({
    resizeDuration: 200,
    wrapAround: true,
    fadeDuration: 200,
    imageFadeDuration: 200,
    disableScrolling: true
  })

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
  <BaseLayout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 text-slate-800">
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
              <a
                :href="coverPhoto"
                :data-lightbox="`listing-${listingId}`"
                :data-title="listingTitle"
                class="block"
              >
                <img
                  :src="coverPhoto"
                  :alt="listingTitle"
                  class="block h-[320px] w-full object-cover md:h-[420px]"
                />
              </a>
              <a
                v-for="(photo, index) in photos"
                :key="`lightbox-photo-${index}`"
                :href="photo"
                :data-lightbox="`listing-${listingId}`"
                :data-title="`${listingTitle} ${index + 1}`"
                class="hidden"
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
                  <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Teljesítmény</dt>
                  <dd class="mt-1 text-base font-semibold text-slate-800">{{ formatHorsepower(listing.horsepower) }}</dd>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                  <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Karosszéria</dt>
                  <dd class="mt-1 text-base font-semibold text-slate-800">{{ listing.car?.body_type || 'Nincs megadva' }}</dd>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                  <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Szín</dt>
                  <dd class="mt-1 text-base font-semibold text-slate-800">{{ listing.car?.color || 'Nincs megadva' }}</dd>
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
              <p class="mt-1 text-base text-slate-700"><span class="font-semibold">Email:</span> {{ sellerEmail || 'Nincs megadva' }}</p>
              <p class="mt-1 text-base text-slate-700"><span class="font-semibold">Telefon:</span> {{ sellerPhone || 'Nincs megadva' }}</p>
              <div class="mt-4 flex flex-wrap gap-3">
                <a
                  v-if="sellerEmail"
                  :href="`mailto:${sellerEmail}`"
                  class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 no-underline transition hover:bg-slate-50"
                >
                  Email küldése
                </a>
                <span
                  v-else
                  class="inline-flex items-center rounded-lg border border-slate-200 bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-500"
                >
                  Email: Nincs megadva
                </span>
                <a
                  v-if="sellerPhone"
                  :href="`tel:${sellerPhone}`"
                  class="inline-flex items-center rounded-lg border border-orange-500 bg-orange-500 px-4 py-2 text-sm font-semibold text-white no-underline transition hover:bg-orange-600"
                >
                  Hívás indítása
                </a>
                <span
                  v-else
                  class="inline-flex items-center rounded-lg border border-slate-200 bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-500"
                >
                  Telefon: Nincs megadva
                </span>
              </div>
            </div>
          </article>
        </section>
      </main>
    </div>
  </BaseLayout>
</template>

<route lang="yaml">
name: listing.detail
path: /listing/:id
meta:
  title: Hirdetés részletei
</route>
