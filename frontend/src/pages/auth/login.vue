<script setup>
import { storeToRefs } from 'pinia'

import BaseHeader from '@components/layout/BaseHeader.vue'
import { useAuthStore } from '@stores/AuthStore.mjs'

const authStore = useAuthStore()
const { loading, errorMessage, successMessage, loginForm, isAuthenticated } = storeToRefs(authStore)

const submit = async () => {
  await authStore.login()
}
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 text-slate-800">
    <BaseHeader />

    <main class="mx-auto max-w-[680px] px-4 py-8 md:px-6">
      <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="m-0 text-3xl font-extrabold text-slate-800">Bejelentkezés</h1>
        <p class="mt-3 mb-0 text-slate-600">
          Jelentkezz be a fiókodba.
        </p>

        <template v-if="isAuthenticated">
          <p class="mt-4 mb-0 rounded-lg bg-green-100 px-3 py-2 text-sm font-bold text-green-700">
            Már be vagy jelentkezve.
          </p>

          <RouterLink
            to="/"
            class="mt-4 inline-flex w-full items-center justify-center rounded-lg bg-orange-500 px-4 py-2.5 text-sm font-bold text-white no-underline hover:bg-orange-600"
          >
            Vissza a főoldalra
          </RouterLink>
        </template>

        <form v-else class="space-y-4" @submit.prevent="submit">
          <label class="block">
            <span class="mb-1 block text-sm font-bold text-slate-700">Email</span>
            <div class="rounded-lg border border-slate-300 bg-white px-3 py-2">
              <input
                v-model="loginForm.email"
                type="email"
                class="w-full border-0 bg-transparent p-0 text-sm text-slate-800 outline-none"
                placeholder="pelda@email.com"
                required
              />
            </div>
          </label>

          <label class="block">
            <span class="mb-1 block text-sm font-bold text-slate-700">Jelszó</span>
            <div class="rounded-lg border border-slate-300 bg-white px-3 py-2">
              <input
                v-model="loginForm.password"
                type="password"
                class="w-full border-0 bg-transparent p-0 text-sm text-slate-800 outline-none"
                placeholder="********"
                required
              />
            </div>
          </label>

          <p v-if="errorMessage" class="m-0 rounded-lg bg-red-100 px-3 py-2 text-sm font-bold text-red-700">
            {{ errorMessage }}
          </p>
          <p v-if="successMessage" class="m-0 rounded-lg bg-green-100 px-3 py-2 text-sm font-bold text-green-700">
            {{ successMessage }}
          </p>

          <button
            type="submit"
            class="w-full rounded-lg bg-orange-500 px-4 py-2.5 text-sm font-bold text-white hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-70"
            :disabled="loading"
          >
            {{ loading ? 'Folyamatban...' : 'Bejelentkezés' }}
          </button>
        </form>

        <p class="mt-4 mb-0 text-sm text-slate-600">
          Nincs még fiókod?
          <RouterLink to="/auth/register" class="font-bold text-orange-600 no-underline hover:text-orange-700">
            Regisztrálj itt
          </RouterLink>
        </p>
      </section>
    </main>
  </div>
</template>

<route lang="yaml">
name: auth-login
meta:
  title: Bejelentkezes
</route>
