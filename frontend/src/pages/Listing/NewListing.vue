<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useListing } from '@stores/NewListingStore.mjs'
import BaseHeader from '@components/layout/BaseHeader.vue'

const router = useRouter()
const listingStore = useListing()

const form = ref({
  title: '',
  description: '',
  brand: '',
  model: '',
  year: '',
  price: '',
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

const handleImageUpload = (event) => {
  const files = Array.from(event.target.files)
  form.value.images = files
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

    const createdListing = await listingStore.createListing(form.value)

    if (!createdListing?.id) {
      throw new Error('Nem sikerült betölteni az új hirdetés azonosítóját.')
    }

    successMessage.value = 'Hírdetés sikeresen létrehozva!'
    
    // form "lenullázása"
    form.value = {
      title: '',
      description: '',
      brand: '',
      model: '',
      year: '',
      price: '',
      fuelType: '',
      bodyType: '',
      mileage: '',
      transmission: '',
      color: '',
      engineSize: '',
      images: []
    }

    await router.push(`/listing/${createdListing.id}`)
  } catch (error) {
    const validationErrors = error.response?.data?.errors
    const firstValidationError = validationErrors
      ? Object.values(validationErrors)[0]?.[0]
      : null
    errorMessage.value = firstValidationError || error.response?.data?.message || error.message || 'Hiba a hírdetés létrehozásakor!'
    console.error(error)
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 text-slate-800">
    <BaseHeader />

    <main class="mx-auto max-w-[1320px] px-4 pt-6 pb-10 md:px-6 flex justify-center">
      <section class="w-full">
        <h1 class="text-[clamp(2rem,2.5vw,3rem)] mb-3 font-extrabold text-slate-800 text-center">Új hírdetés létrehozása</h1>

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
                Hírdetés címe <span class="text-red-500">*</span>
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
                  class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                />
              </div>
            </div>

            <!-- évjárat és ár -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="year" class="block text-sm font-semibold text-slate-700 mb-2">
                  Évjárat
                </label>
                <input
                  id="year"
                  v-model="form.year"
                  type="number"
                  placeholder="pl. 2020"
                  class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                />
              </div>

              <div>
                <label for="price" class="block text-sm font-semibold text-slate-700 mb-2">
                  Ár <span class="text-red-500">*</span>
                </label>
                <input
                  id="price"
                  v-model="form.price"
                  type="number"
                  required
                  placeholder="pl. 1000000"
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
                  Kilóméteróra állás
                </label>
                <input
                  id="mileage"
                  v-model="form.mileage"
                  type="number"
                  placeholder="pl. 150000"
                  class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                />
              </div>

              <div>
                <label for="transmission" class="block text-sm font-semibold text-slate-700 mb-2">
                  Váltó
                </label>
                <select
                  id="transmission"
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
                  placeholder="pl. 2000"
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
                Leírás <span class="text-red-500">*</span>
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
              <button
                type="submit"
                :disabled="isLoading"
                class="flex-1 rounded-lg bg-orange-500 px-6 py-3 text-base font-bold text-white shadow-md hover:bg-orange-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
              >
                {{ isLoading ? 'Feldolgozás...' : 'Hírdetés létrehozása' }}
              </button>
              <RouterLink
                to="/"
                class="flex-1 rounded-lg border-2 border-slate-300 px-6 py-3 text-base font-bold text-slate-700 hover:bg-slate-50 transition-colors no-underline text-center"
              >
                Mégse
              </RouterLink>
            </div>
          </form>
        </div>
      </section>
    </main>
  </div>
</template>

<route lang="yaml">
name: listings.create
path: /listing/new
meta:
  title: Új hírdetés létrehozása
</route>


