<script setup>
import { storeToRefs } from 'pinia'
import { computed, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import carBlueImage from '@assets/images/home/car-blue.jpg'
import { useAuthStore } from '@stores/AuthStore.mjs'
import { useFavouritesStore } from '@stores/FavouritesStore.mjs'

const props = defineProps({
  car: {
    type: Object,
    required: true
  }
})

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()
const favouritesStore = useFavouritesStore()
const { isAuthenticated } = storeToRefs(authStore)
const isFavouriteUpdating = ref(false)

const listingId = computed(() => props.car?.listingId)
const hasListing = computed(() => Boolean(listingId.value))
const isFavourite = computed(() => isAuthenticated.value && hasListing.value && favouritesStore.isFavourite(listingId.value))

const favouriteButtonLabel = computed(() => {
  if (!hasListing.value) {
    return ''
  }

  return isFavourite.value ? 'Eltávolítás a gyűjteményből' : 'Felvétel a gyűjteménybe'
})

const toggleFavourite = async (event) => {
  event.preventDefault()
  event.stopPropagation()

  if (!hasListing.value || isFavouriteUpdating.value) {
    return
  }

  if (!isAuthenticated.value) {
    const redirect = encodeURIComponent(route.fullPath || '/')
    await router.push(`/auth/login?redirect=${redirect}`)
    return
  }

  isFavouriteUpdating.value = true

  try {
    await favouritesStore.toggleFavourite(listingId.value)
  } catch {
  } finally {
    isFavouriteUpdating.value = false
  }
}

const formatPrice = (value) => {
  const numeric = Number(value)

  if (Number.isNaN(numeric)) {
    return 'Nincs megadva'
  }

  return `${new Intl.NumberFormat('hu-HU').format(numeric)} Ft`
}

const formatYear = (value) => {
  if (value === null || value === undefined || value === '') {
    return 'N/A'
  }

  return String(value)
}

const formatMileage = (value) => {
  const numeric = Number(value)

  if (Number.isNaN(numeric)) {
    return 'N/A km'
  }

  return `${new Intl.NumberFormat('hu-HU').format(numeric)} km`
}

const formatHorsepower = (value) => {
  const rawValue = String(value ?? '').trim()
  const normalized = rawValue.replace(',', '.')
  const extracted = normalized.match(/\d+(?:\.\d+)?/)
  const numeric = Number(extracted?.[0] ?? normalized)

  if (Number.isNaN(numeric)) {
    return 'N/A LE'
  }

  return `${new Intl.NumberFormat('hu-HU').format(numeric)} LE`
}

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
</script>

<template>
  <RouterLink
    v-if="props.car.listingId"
    :to="`/listing/${props.car.listingId}`"
    class="block h-full overflow-hidden rounded-2xl border border-slate-200 bg-white text-inherit no-underline shadow-md transition-transform duration-200 hover:-translate-y-1 hover:shadow-xl"
  >
    <article class="flex h-full flex-col">
      <div class="overflow-hidden">
        <img
          :src="resolveImageUrl(props.car.image_url)"
          :alt="props.car.title"
          class="block h-[235px] w-full object-cover max-[640px]:h-[205px]"
          loading="lazy"
        />
      </div>

      <div class="flex flex-1 flex-col px-5 pt-5 pb-5">
        <h3 class="m-0 text-[2rem] leading-tight font-extrabold text-slate-800 max-[640px]:text-[1.6rem]">
          {{ props.car.title }}
        </h3>
        <p class="mt-3 mb-0 max-w-[33ch] text-[1.1rem] leading-relaxed text-slate-500 max-[640px]:text-base">
          {{ props.car.description }}
        </p>
        <div class="mt-auto flex items-end justify-between gap-4 pt-4">
          <div class="flex flex-wrap items-center gap-2">
            <span class="rounded-full bg-slate-200 px-3 py-1 text-sm font-bold text-slate-600">{{ formatYear(props.car.year) }}</span>
            <span class="rounded-full bg-slate-200 px-3 py-1 text-sm font-bold text-slate-600">{{ formatMileage(props.car.mileage) }}</span>
            <span class="rounded-full bg-slate-200 px-3 py-1 text-sm font-bold text-slate-600">{{ formatHorsepower(props.car.horsepower) }}</span>
          </div>
          <p class="m-0 shrink-0 text-xl font-extrabold text-slate-900 max-[640px]:text-lg">
            {{ formatPrice(props.car.price) }}
          </p>
        </div>
        <button
          type="button"
          class="mt-4 inline-flex w-full items-center justify-center rounded-lg border px-4 py-2.5 text-sm font-bold transition"
          :class="isFavourite ? 'border-red-500 bg-red-500 text-white hover:bg-red-600' : 'border-orange-500 bg-orange-500 text-white hover:bg-orange-600'"
          :disabled="isFavouriteUpdating"
          @click="toggleFavourite"
        >
          {{ isFavouriteUpdating ? 'Feldolgozás...' : favouriteButtonLabel }}
        </button>
      </div>
    </article>
  </RouterLink>

  <article
    v-else
    class="flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md transition-transform duration-200 hover:-translate-y-1 hover:shadow-xl"
  >
    <div class="overflow-hidden">
      <img
        :src="resolveImageUrl(props.car.image_url)"
        :alt="props.car.title"
        class="block h-[235px] w-full object-cover max-[640px]:h-[205px]"
        loading="lazy"
      />
    </div>

    <div class="flex flex-1 flex-col px-5 pt-5 pb-5">
      <h3 class="m-0 text-[2rem] leading-tight font-extrabold text-slate-800 max-[640px]:text-[1.6rem]">
        {{ props.car.title }}
      </h3>
      <p class="mt-3 mb-0 max-w-[33ch] text-[1.1rem] leading-relaxed text-slate-500 max-[640px]:text-base">
        {{ props.car.description }}
      </p>
      <div class="mt-auto flex items-end justify-between gap-4 pt-4">
        <div class="flex flex-wrap items-center gap-2">
          <span class="rounded-full bg-slate-200 px-3 py-1 text-sm font-bold text-slate-600">{{ formatYear(props.car.year) }}</span>
          <span class="rounded-full bg-slate-200 px-3 py-1 text-sm font-bold text-slate-600">{{ formatMileage(props.car.mileage) }}</span>
          <span class="rounded-full bg-slate-200 px-3 py-1 text-sm font-bold text-slate-600">{{ formatHorsepower(props.car.horsepower) }}</span>
        </div>
        <p class="m-0 shrink-0 text-xl font-extrabold text-slate-900 max-[640px]:text-lg">
          {{ formatPrice(props.car.price) }}
        </p>
      </div>
    </div>
  </article>
</template>
