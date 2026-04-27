<script setup>
import { storeToRefs } from 'pinia'
import { computed, ref } from 'vue'
import { useRouter } from 'vue-router'
import { Menu, X } from 'lucide-vue-next'
import { useAuthStore } from '@stores/AuthStore.mjs'

const baseNavigationItems = [
  { label: 'Gyűjtemény', route: '/collection' },
  { label: 'Új hirdetés', route: '/listing/new', isActive: false }
]

const isMenuOpen = ref(false)
const router = useRouter()
const authStore = useAuthStore()
const { isAuthenticated, userName, isAdmin } = storeToRefs(authStore)

const navigationItems = computed(() => {
  const items = [...baseNavigationItems]

  if (isAuthenticated.value && !isAdmin.value) {
    items.push({ label: 'Profilom', route: '/my-profile', isActive: false })
  }

  if (isAdmin.value) {
    items.push({ label: 'Admin', route: '/admin/listings', isActive: false })
  }

  return items
})

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}

const closeMenu = () => {
  isMenuOpen.value = false
}

const logout = () => {
  authStore.logout()
  closeMenu()
  router.push('/')
}
</script>

<template>
  <header class="mt-3 px-4 md:mt-4 md:px-6">
    <div class="mx-auto max-w-[1320px] rounded-2xl border border-white/15 bg-gradient-to-r from-slate-950/90 via-slate-900/90 to-blue-950/90 shadow-lg shadow-slate-950/40 backdrop-blur-xl">
      <div class="px-4 py-2.5 md:px-6 md:py-3">
      <div class="flex items-center justify-between gap-3">
        <RouterLink to="/" class="inline-flex items-center gap-2 text-white no-underline" aria-label="CarLink főoldal">
          <span class="text-3xl font-bold tracking-tight max-sm:text-2xl">CarLink</span>
        </RouterLink>

        <nav class="hidden items-center gap-6 md:flex" aria-label="Fő navigáció">
          <RouterLink
            v-for="item in navigationItems"
            :key="item.label"
            :to="item.route"
            :class="[
              'text-base font-semibold text-slate-300 no-underline transition-colors hover:text-white',
              item.label === 'Autókereskedés' ? 'text-orange-500' : ''
            ]"
          >
            {{ item.label }}
          </RouterLink>
        </nav>

        <div class="hidden items-center gap-3 md:flex">
          <span v-if="isAuthenticated" class="text-sm font-semibold text-slate-200">
            {{ userName }}
          </span>

          <button
            v-if="isAuthenticated"
            type="button"
            class="rounded-lg bg-orange-500 px-4 py-2.5 text-sm font-bold text-white shadow-md hover:bg-orange-600"
            @click="logout"
          >
            Kijelentkezés
          </button>

          <RouterLink
            v-else
            to="/auth/login"
            class="items-center rounded-lg bg-orange-500 px-4 py-2.5 text-sm font-bold text-white no-underline shadow-md hover:bg-orange-600"
          >
            <span>Bejelentkezés</span>
          </RouterLink>
        </div>

        <button
          type="button"
          class="inline-flex items-center justify-center rounded-lg border border-slate-600/90 bg-slate-900/40 p-2 text-white md:hidden"
          aria-label="Menünyitás"
          @click="toggleMenu"
        >
          <X v-if="isMenuOpen" :size="20" />
          <Menu v-else :size="20" />
        </button>
      </div>

      <div v-if="isMenuOpen" class="mt-3 rounded-xl border border-white/15 bg-gradient-to-r from-slate-950/90 via-slate-900/90 to-blue-950/90 p-3 shadow-lg shadow-slate-950/40 backdrop-blur-xl md:hidden">
        <nav class="flex flex-col gap-2" aria-label="Fő navigáció mobil">
          <RouterLink
            v-for="item in navigationItems"
            :key="item.label"
            :to="item.route"
            :class="[
              'rounded-md px-2 py-2 text-sm font-semibold text-slate-200 no-underline hover:bg-slate-800',
              item.label === 'Autókereskedés' ? 'text-orange-500' : ''
            ]"
            @click="closeMenu"
          >
            {{ item.label }}
          </RouterLink>
        </nav>

        <div v-if="isAuthenticated" class="mt-3">
          <p class="m-0 text-sm font-semibold text-slate-200">Bejelentkezve: {{ userName }}</p>
          <button
            type="button"
            class="mt-2 inline-flex w-full items-center justify-center rounded-lg bg-orange-500 px-4 py-2.5 text-sm font-bold text-white"
            @click="logout"
          >
            Kijelentkezés
          </button>
        </div>

        <RouterLink
          v-else
          to="/auth/login"
          class="mt-3 inline-flex w-full items-center justify-center rounded-lg bg-orange-500 px-4 py-2.5 text-sm font-bold text-white no-underline"
          @click="closeMenu"
        >
          <span>Bejelentkezés / Regisztráció</span>
        </RouterLink>
      </div>
      </div>
    </div>
  </header>
</template>
