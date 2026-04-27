<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useListing } from '@stores/NewListingStore.mjs'
import { useAuthStore } from '@stores/AuthStore.mjs'
import BaseLayout from '@layouts/BaseLayout.vue'
import BaseConfirmDialog from '@components/layout/BaseConfirmDialog.vue'

const router = useRouter()
const listingStore = useListing()
const authStore = useAuthStore()

const form = ref({
  title: '',
  description: '',
  brand: '',
  model: '',
  year: '',
  price: '',
  horsepower: '',
  fuelType: '',
  bodyType: '',
  mileage: '',
  transmission: '',
  color: '',
  engineSize: '',
  images: []
})

const isLoading = ref(false)
const errorMessage = ref('')
const successMessage = ref('')
const isApprovalDialogOpen = ref(false)
const createdListingId = ref(null)

onMounted(() => {
  if (!authStore.isAuthenticated) {
    router.replace('/auth/login?redirect=/listing/new')
  }
})

const handleImageUpload = (event) => {
  const files = Array.from(event.target.files)
  form.value.images = files
}

const closeApprovalDialog = () => {
  isApprovalDialogOpen.value = false
}

const handleApprovalDialogConfirm = async () => {
  isApprovalDialogOpen.value = false

  if (createdListingId.value) {
    await router.push(`/listing/${createdListingId.value}`)
  }
}

const preventNegativeValue = (field) => {
  const raw = String(form.value[field] ?? '')

  if (!raw || !raw.includes('-')) {
    return
  }

  form.value[field] = raw.replace(/-/g, '')
}

const handleSubmit = async () => {
  if (isLoading.value) {
    return
  }

  isLoading.value = true
  errorMessage.value = ''
  successMessage.value = ''

  try {
    if (
      !form.value.description ||
      !form.value.brand ||
      !form.value.model ||
      !form.value.year ||
      !form.value.price ||
      !form.value.horsepower ||
      !form.value.fuelType ||
      !form.value.bodyType ||
      !form.value.mileage ||
      !form.value.transmission ||
      !form.value.color ||
      !form.value.engineSize
    ) {
      errorMessage.value = 'Kérjük, töltse ki a kötelező mezőket!'
      isLoading.value = false
      return
    }

    const numericFields = ['year', 'horsepower', 'price', 'engineSize', 'mileage']
    const hasNegativeValue = numericFields.some(field => Number(form.value[field]) < 0)

    if (hasNegativeValue) {
      errorMessage.value = 'A szám mezőkben nem adhatsz meg negatív értéket!'
      isLoading.value = false
      return
    }

    const createdListing = await listingStore.createListing(form.value)

    if (!createdListing?.id) {
      throw new Error('Nem sikerült betölteni az új hirdetés azonosítóját.')
    }

    successMessage.value = 'Hirdetés sikeresen létrehozva!'
    
    // form "lenullázása"
    form.value = {
      title: '',
      description: '',
      brand: '',
      model: '',
      year: '',
      price: '',
      horsepower: '',
      fuelType: '',
      bodyType: '',
      mileage: '',
      transmission: '',
      color: '',
      engineSize: '',
      images: []
    }

    createdListingId.value = createdListing.id
    isApprovalDialogOpen.value = true
  } catch (error) {
    const validationErrors = error.response?.data?.errors
    const firstValidationError = validationErrors
      ? Object.values(validationErrors)[0]?.[0]
      : null
    errorMessage.value = firstValidationError || error.response?.data?.message || error.message || 'Hiba a hirdetés létrehozásakor!'
    console.error(error)
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <BaseLayout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 text-slate-800">
      <main class="mx-auto max-w-[1320px] px-4 pt-6 pb-10 md:px-6 flex justify-center">
        <section class="w-full">
          <h1 class="text-[clamp(2rem,2.5vw,3rem)] mb-3 font-extrabold text-slate-800 text-center">Új hirdetés létrehozása</h1>
          <div class="rounded-2xl border border-slate-200 bg-white shadow-lg p-8 max-w-2xl mx-auto">
            <div
              v-if="successMessage"
              class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4 text-green-800"
            >
              {{ successMessage }}
            </div>
            <div
              v-if="errorMessage"
              class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-red-800"
            >
              {{ errorMessage }}
            </div>
            <form @submit.prevent="handleSubmit" class="space-y-6">
              <!-- cím -->
              <div>
                <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">
                  Hirdetés címe 
                </label>
                <input
                  id="title"
                  v-model="form.title"
                  type="text"
                  required
                  placeholder="pl. BMW 320D"
                  class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                />
              </div>
              <!-- márka -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="brand" class="block text-sm font-semibold text-slate-700 mb-2">
                    Márka
                  </label>
                  <input
                    id="brand"
                    v-model="form.brand"
                    type="text"
                    placeholder="pl. BMW"
                    required
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                  />
                </div>
                <!-- modell -->
                <div>
                  <label for="model" class="block text-sm font-semibold text-slate-700 mb-2">
                    Modell
                  </label>
                  <input
                    id="model"
                    v-model="form.model"
                    type="text"
                    placeholder="pl. 320D"
                    required
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                  />
                </div>
              </div>
              <!-- évjárat, ár és lóerő -->
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                  <label for="year" class="block text-sm font-semibold text-slate-700 mb-2">
                    Évjárat
                  </label>
                  <input
                    id="year"
                    v-model="form.year"
                    type="number"
                    min="0"
                    placeholder="pl. 2020"
                    required
                    @input="preventNegativeValue('year')"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                  />
                </div>
                <div>
                  <label for="horsepower" class="block text-sm font-semibold text-slate-700 mb-2">
                    Lóerő 
                  </label>
                  <input
                    id="horsepower"
                    v-model="form.horsepower"
                    type="number"
                    min="0"
                    required
                    placeholder="pl. 150"
                    @input="preventNegativeValue('horsepower')"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                  />
                </div>
                <div>
                  <label for="price" class="block text-sm font-semibold text-slate-700 mb-2">
                    Ár 
                  </label>
                  <input
                    id="price"
                    v-model="form.price"
                    type="number"
                    min="0"
                    required
                    placeholder="pl. 1000000"
                    @input="preventNegativeValue('price')"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                  />
                </div>
              </div>
              <!-- üzemanyag és kivitel -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="fuelType" class="block text-sm font-semibold text-slate-700 mb-2">
                    Üzemanyag
                  </label>
                  <select
                    id="fuelType"
                    required
                    v-model="form.fuelType"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                  >
                    <option value="">-- Válassz --</option>
                    <option value="benzin">Benzin</option>
                    <option value="diesel">Diesel</option>
                    <option value="hibrid">Hibrid</option>
                    <option value="elektromos">Elektromos</option>
                  </select>
                </div>
                <div>
                  <label for="bodyType" class="block text-sm font-semibold text-slate-700 mb-2">
                    Kivitel
                  </label>
                  <select
                    id="bodyType"
                    required
                    v-model="form.bodyType"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                  >
                    <option value="">-- Válassz --</option>
                    <option value="sedan">Sedan</option>
                    <option value="kombi">Kombi</option>
                    <option value="suv">SUV</option>
                    <option value="coupe">Coupe</option>
                    <option value="kabriolet">Kabrio</option>
                    <option value="pickup">Pickup</option>
                    <option value="terepjaro">Terepjáró</option>
                    <option value="egyteru">Egyterű</option>
                    <option value="ferdehatu">Ferdehátú</option>
                    <option value="kisbusz">Kisbusz</option>
                    <option value="lepcsoshatu">Lépcsőshátú</option>
                    <option value="mopedauto">Mopedautó</option>
                    <option value="sport">Sport</option>
                    <option value="crossover">Crossover</option>

    
                  </select>
                </div>
              </div>
              <!-- megtett km és váltó -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="mileage" class="block text-sm font-semibold text-slate-700 mb-2">
                    Kilométeróra állás
                  </label>
                  <input
                    id="mileage"
                    v-model="form.mileage"
                    type="number"
                    min="0"
                    placeholder="pl. 150000"
                    required
                    @input="preventNegativeValue('mileage')"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                  />
                </div>
                <div>
                  <label for="transmission" class="block text-sm font-semibold text-slate-700 mb-2">
                    Váltó
                  </label>
                  <select
                    id="transmission"
                    required
                    v-model="form.transmission"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                  >
                    <option value="">-- Válassz --</option>
                    <option value="manualis">Manuális</option>
                    <option value="felautomata">Félautomata</option>
                    <option value="automata">Automata</option>
                  </select>
                </div>
              </div>
              <!-- szín és motorméret -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="color" class="block text-sm font-semibold text-slate-700 mb-2">
                    Szín
                  </label>
                  <input
                    id="color"
                    v-model="form.color"
                    type="text"
                    placeholder="pl. Fekete"
                    required
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                  />
                </div>
                <div>
                  <label for="engineSize" class="block text-sm font-semibold text-slate-700 mb-2">
                    Motorméret (cm³)
                  </label>
                  <input
                    id="engineSize"
                    v-model="form.engineSize"
                    type="number"
                    min="0"
                    placeholder="pl. 2000"
                    required
                    @input="preventNegativeValue('engineSize')"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                  />
                </div>
              </div>
              <!-- képek feltöltése -->
              <div>
                <label for="images" class="block text-sm font-semibold text-slate-700 mb-2">
                  Képek feltöltése
                </label>
                <input
                  id="images"
                  type="file"
                  multiple
                  accept="image/*"
                  @change="handleImageUpload"
                  class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                />
                <p class="mt-2 text-sm text-slate-500">
                  {{ form.images.length }} kép kiválasztva
                </p>
              </div>
              <!-- leírás -->
              <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
                  Leírás
                </label>
                <textarea
                  id="description"
                  v-model="form.description"
                  required
                  rows="6"
                  placeholder="Írja le az autó állapotát, jellegzetességeit..."
                  class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                />
              </div>
              <!-- gombok -->
              <div class="flex gap-4 pt-4">
                <RouterLink
                  to="/"
                  class="flex-1 rounded-lg border-2 border-slate-300 px-6 py-3 text-base font-bold text-slate-700 hover:bg-slate-50 transition-colors no-underline text-center"
                >
                  Mégse
                </RouterLink>
                <button
                  type="submit"
                  :disabled="isLoading"
                  class="flex-1 rounded-lg bg-orange-500 px-6 py-3 text-base font-bold text-white shadow-md hover:bg-orange-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                >
                  {{ isLoading ? 'Feldolgozás...' : 'Hirdetés létrehozása' }}
                </button>
              </div>
            </form>
          </div>
        </section>
      </main>
    </div>
    <BaseConfirmDialog
      v-model="isApprovalDialogOpen"
      title="Hirdetés rögzítve"
      message="A hirdetése létrejött, de megjelenéséhez Admin jóváhagyása szükséges."
      confirm-text="Rendben"
      cancel-text="Bezárás"
      @cancel="closeApprovalDialog"
      @confirm="handleApprovalDialogConfirm"
    />
  </BaseLayout>
</template>

<route lang="yaml">
name: listings.create
path: /listing/new
meta:
  title: Új hirdetés létrehozása
</route>


