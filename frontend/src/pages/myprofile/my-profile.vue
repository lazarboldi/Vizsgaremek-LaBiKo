<script setup>
import { computed, onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import BaseLayout from '@layouts/BaseLayout.vue'
import carBlueImage from '@assets/images/home/car-blue.jpg'
import { useAuthStore } from '@stores/AuthStore.mjs'
import { api } from '@utils/http.mjs'

const router = useRouter()
const authStore = useAuthStore()

const loading = ref(false)
const errorMessage = ref('')
const profile = ref(null)
const listings = ref([])

const backendOrigin = import.meta.env.VITE_BACKEND_URL?.replace(/\/api\/?$/, '/')

const authHeaders = () => ({
  Authorization: `Bearer ${authStore.token}`
})

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

const formatPrice = (value) => {
  const amount = Number(value)

  if (Number.isNaN(amount)) {
    return 'Nincs megadva'
  }

  return `${new Intl.NumberFormat('hu-HU').format(amount)} Ft`
}

const formattedRegisteredAt = computed(() => {
  const createdAt = profile.value?.created_at

  if (!createdAt) {
    return 'Nincs megadva'
  }

  return new Intl.DateTimeFormat('hu-HU', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  }).format(new Date(createdAt))
})

const loadProfile = async () => {
  loading.value = true
  errorMessage.value = ''

  try {
    const response = await api.get('users/me', {
      headers: authHeaders()
    })

    const payload = response?.data?.data || {}
    profile.value = payload?.user?.data || payload?.user || null
    listings.value = payload?.listings?.data || payload?.listings || []
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Nem sikerült betölteni a profil adatokat.'
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  if (!authStore.isAuthenticated) {
    await router.replace('/auth/login?redirect=/my-profile')
    return
  }

  await loadProfile()
})
</script>

<template>
  <BaseLayout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 text-slate-800">
      <main class="mx-auto max-w-[1320px] px-4 pt-6 pb-10 md:px-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
          <h1 class="m-0 text-[clamp(1.8rem,2.4vw,2.8rem)] font-extrabold text-slate-800">Profilom</h1>
          <p class="mt-2 mb-6 text-slate-600">Itt láthatod a regisztrációkor megadott adataidat és a saját hirdetéseidet.</p>

          <div v-if="loading" class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-600">
            Profil adatok betöltése...
          </div>

          <div v-else>
            <p v-if="errorMessage" class="mb-5 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700">
              {{ errorMessage }}
            </p>

            <article v-if="profile" class="mb-6 rounded-xl border border-slate-200 bg-slate-50 p-5">
              <h2 class="m-0 text-lg font-bold text-slate-800">Személyes adatok</h2>
              <dl class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                <div>
                  <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Név</dt>
                  <dd class="mt-1 text-sm font-semibold text-slate-800">{{ profile.name || 'Nincs megadva' }}</dd>
                </div>
                <div>
                  <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Email</dt>
                  <dd class="mt-1 text-sm font-semibold text-slate-800">{{ profile.email || 'Nincs megadva' }}</dd>
                </div>
                <div>
                  <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Telefonszám</dt>
                  <dd class="mt-1 text-sm font-semibold text-slate-800">{{ profile.phone || 'Nincs megadva' }}</dd>
                </div>
                <div>
                  <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Tagság kezdete</dt>
                  <dd class="mt-1 text-sm font-semibold text-slate-800">{{ formattedRegisteredAt }}</dd>
                </div>
              </dl>
            </article>

            <section>
              <h2 class="m-0 text-lg font-bold text-slate-800">Saját hirdetéseim</h2>
              <p class="mt-1 mb-4 text-sm text-slate-600">Ezeket a hirdetéseket te hoztad létre.</p>

              <div v-if="listings.length === 0" class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-600">
                Még nincs saját hirdetésed.
              </div>

              <div v-else class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <article
                  v-for="listing in listings"
                  :key="listing.id"
                  class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50"
                >
                  <img
                    :src="resolveImageUrl(listing.car?.images?.[0]?.image_url)"
                    :alt="`${listing.car?.brand || ''} ${listing.car?.model || ''}`.trim() || 'Hirdetés képe'"
                    class="h-52 w-full object-cover"
                  />
                  <div class="p-4">
                    <h3 class="m-0 text-base font-bold text-slate-800">
                      {{ listing.car?.brand || 'Ismeretlen márka' }} {{ listing.car?.model || '' }}
                    </h3>
                    <p class="mt-1 mb-0 text-sm text-slate-600">Hirdetés ID: {{ listing.id }}</p>
                    <p class="mt-1 mb-0 text-sm font-semibold text-slate-700">Ár: {{ formatPrice(listing.price) }}</p>
                    <RouterLink
                      :to="`/listing/${listing.id}`"
                      class="mt-3 inline-flex items-center rounded-lg border border-orange-500 bg-orange-500 px-4 py-2 text-sm font-bold text-white no-underline hover:bg-orange-600"
                    >
                      Megnyitás
                    </RouterLink>
                  </div>
                </article>
              </div>
            </section>
          </div>
        </section>
      </main>
    </div>
  </BaseLayout>
</template>

<route lang="yaml">
name: my-profile
path: /my-profile
alias:
  - /myprofile
  - /myprofile/my-profile
meta:
  title: Profilom
</route>
