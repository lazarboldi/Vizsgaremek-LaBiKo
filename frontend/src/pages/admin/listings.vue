<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import BaseLayout from '@layouts/BaseLayout.vue'
import BaseConfirmDialog from '@components/layout/BaseConfirmDialog.vue'
import { useAuthStore } from '@stores/AuthStore.mjs'
import { useListing } from '@stores/NewListingStore.mjs'
import { api } from '@utils/http.mjs'

const router = useRouter()
const authStore = useAuthStore()
const listingStore = useListing()

const listings = ref([])
const loading = ref(false)
const deletingListingId = ref(null)
const approvingListingId = ref(null)
const pendingDeleteListingId = ref(null)
const isDeleteDialogOpen = ref(false)
const errorMessage = ref('')
const successMessage = ref('')

const formatPrice = (value) => {
  const amount = Number(value || 0)
  return new Intl.NumberFormat('hu-HU').format(amount)
}

const statusLabel = (status) => {
  switch (String(status || '').toLowerCase()) {
    case 'pending':
      return 'Jóváhagyásra vár'
    case 'active':
      return 'Aktív'
    case 'sold':
      return 'Eladva'
    case 'archived':
      return 'Archivált'
    default:
      return 'Ismeretlen'
  }
}

const authHeaders = () => ({
  Authorization: `Bearer ${authStore.token}`
})

const loadAdminListings = async () => {
  loading.value = true
  errorMessage.value = ''

  try {
    const response = await api.get('admin/listings', {
      headers: authHeaders()
    })

    listings.value = response?.data?.data || []
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Nem sikerült betölteni az admin hirdetéseket.'
  } finally {
    loading.value = false
  }
}

const openDeleteDialog = (listingId) => {
  if (deletingListingId.value) {
    return
  }

  pendingDeleteListingId.value = listingId
  isDeleteDialogOpen.value = true
}

const closeDeleteDialog = () => {
  isDeleteDialogOpen.value = false
  pendingDeleteListingId.value = null
}

const deleteListing = async () => {
  if (deletingListingId.value || approvingListingId.value) {
    return
  }

  const listingId = pendingDeleteListingId.value

  if (!listingId) {
    return
  }

  isDeleteDialogOpen.value = false
  deletingListingId.value = listingId
  errorMessage.value = ''
  successMessage.value = ''

  try {
    await api.delete(`admin/listings/${listingId}`, {
      headers: authHeaders()
    })

    listings.value = listings.value.filter(item => Number(item.id) !== Number(listingId))

    try {
      listingStore.removeListingFromState(listingId)
    } catch {
    }

    successMessage.value = 'A hirdetés sikeresen törölve.'
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Nem sikerült törölni a hirdetést.'
  } finally {
    deletingListingId.value = null
    pendingDeleteListingId.value = null
  }
}

const approveListing = async (listingId) => {
  if (deletingListingId.value || approvingListingId.value) {
    return
  }

  approvingListingId.value = listingId
  errorMessage.value = ''
  successMessage.value = ''

  try {
    await api.patch(`admin/listings/${listingId}/approve`, {}, {
      headers: authHeaders()
    })

    listings.value = listings.value.filter(item => Number(item.id) !== Number(listingId))
    successMessage.value = 'A hirdetés jóváhagyva, megjelent a nyilvános listában.'
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Nem sikerült jóváhagyni a hirdetést.'
  } finally {
    approvingListingId.value = null
  }
}

onMounted(async () => {
  if (!authStore.isAuthenticated) {
    await router.replace('/auth/login?redirect=/admin/listings')
    return
  }

  if (!authStore.isAdmin) {
    await router.replace('/')
    return
  }

  await loadAdminListings()
})
</script>

<template>
  <BaseLayout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 text-slate-800">
      <main class="mx-auto max-w-[1320px] px-4 pt-6 pb-10 md:px-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
          <h1 class="m-0 text-[clamp(1.8rem,2.4vw,2.8rem)] font-extrabold text-slate-800">Admin hirdetéskezelés</h1>
          <p class="mt-2 mb-6 text-slate-600">Itt az összes hirdetést megtekintheti, a várakozókat jóváhagyhatja, és kezelheti.</p>
          <p v-if="errorMessage" class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700">
            {{ errorMessage }}
          </p>
          <p v-if="successMessage" class="mb-4 rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-sm font-semibold text-green-700">
            {{ successMessage }}
          </p>
          <div v-if="loading" class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-600">
            Hirdetések betöltése...
          </div>
          <div v-else-if="listings.length === 0" class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-600">
            Jelenleg nincs hirdetés.
          </div>
          <div v-else class="space-y-3">
            <article
              v-for="listing in listings"
              :key="listing.id"
              class="rounded-xl border border-slate-200 bg-slate-50 p-4 md:p-5"
            >
              <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                  <h2 class="m-0 text-lg font-bold text-slate-800">
                    {{ listing.car?.brand || 'Ismeretlen márka' }} {{ listing.car?.model || '' }}
                  </h2>
                  <p class="mt-1 mb-0 text-sm text-slate-600">Hirdetés ID: {{ listing.id }}</p>
                  <p class="mt-1 mb-0 text-sm text-slate-600">Feltöltő: {{ listing.user?.name || 'Ismeretlen' }} ({{ listing.user?.email || 'n/a' }})</p>
                  <p class="mt-1 mb-0 text-sm text-slate-600">Állapot: {{ statusLabel(listing.status) }}</p>
                  <p class="mt-1 mb-0 text-sm font-semibold text-slate-700">Ár: {{ formatPrice(listing.price) }} Ft</p>
                </div>
                <div class="flex flex-wrap gap-2">
                  <RouterLink
                    :to="`/listing/${listing.id}`"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 no-underline hover:bg-slate-50"
                  >
                    Megnyitás
                  </RouterLink>
                  <button
                    v-if="listing.status === 'pending'"
                    type="button"
                    class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-70"
                    :disabled="approvingListingId === listing.id || Boolean(deletingListingId)"
                    @click="approveListing(listing.id)"
                  >
                    {{ approvingListingId === listing.id ? 'Jóváhagyás...' : 'Jóváhagyás' }}
                  </button>
                  <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-70"
                    :disabled="deletingListingId === listing.id || Boolean(approvingListingId)"
                    @click="openDeleteDialog(listing.id)"
                  >
                    {{
                      deletingListingId === listing.id
                        ? (listing.status === 'pending' ? 'Elutasítás...' : 'Törlés...')
                        : (listing.status === 'pending' ? 'Elutasítás' : 'Törlés')
                    }}
                  </button>
                </div>
              </div>
            </article>
          </div>
        </section>
      </main>
    </div>
    <BaseConfirmDialog
      v-model="isDeleteDialogOpen"
      title="Hirdetés törlése"
      message="Biztosan törölni szeretné ezt a hirdetést? Ez a művelet nem vonható vissza."
      confirm-text="Igen, törlöm"
      confirm-variant="danger"
      cancel-text="Mégse"
      @cancel="closeDeleteDialog"
      @confirm="deleteListing"
    />
  </BaseLayout>
</template>

<route lang="yaml">
name: admin-listings
path: /admin/listings
meta:
  title: Admin hirdetések
</route>