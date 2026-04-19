<script setup>
import {
  ChevronRight,
} from 'lucide-vue-next'

import BaseCard from '@components/layout/BaseCard.vue'
import BaseHeader from '@components/layout/BaseHeader.vue'
import { useHomeStore } from '@stores/HomeStore.mjs'

const homeStore = useHomeStore()
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 text-slate-800">
    <BaseHeader />

    <main class="mx-auto grid max-w-[1320px] grid-cols-1 gap-6 px-4 pt-6 pb-10 md:px-6 lg:grid-cols-[280px_minmax(0,1fr)] lg:pt-9 lg:pb-12">
      <aside
        class="w-full self-start overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg"
        aria-label="Szűrési panel"
      >
        <h2 class="m-0 border-b border-slate-200 px-5 py-5 text-4xl leading-tight font-extrabold max-sm:text-3xl">
          Szűrés
        </h2>
        <ul class="m-0 list-none p-2.5">
          <li v-for="filter in homeStore.filters" :key="filter.id" class="not-last:mb-1">
            <button
              type="button"
              :class="[
                'flex w-full items-center justify-between rounded-lg border-0 bg-transparent px-3 py-3.5 text-slate-600 transition-all duration-200 hover:bg-slate-100',
                homeStore.activeFilterId === filter.id
                  ? 'rounded-l-none border-l-[3px] border-l-orange-500 bg-slate-50 text-slate-900'
                  : ''
              ]"
              @click="homeStore.activeFilterId = filter.id"
            >
              <span class="inline-flex items-center gap-[0.7rem]">
                <span class="text-[1.02rem] font-bold">{{ filter.label }}</span>
              </span>
              <ChevronRight :size="18" class="text-slate-400" />
            </button>
          </li>
        </ul>
      </aside>

      <section aria-label="Autók listázása">
        <h1 class="m-0 text-[clamp(2rem,2.5vw,3rem)] font-extrabold text-slate-800">Autókereskedés</h1>
        <p class="mt-1 mb-6 text-xl font-semibold text-slate-500 max-sm:text-lg">
          Válogasson kínálatunkból!
        </p>

        <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">
          <BaseCard v-for="car in homeStore.cars" :key="car.id" :car="car" />
        </div>
      </section>
    </main>
  </div>
</template>

<route lang="yaml">
name: index
meta:
  title: Főoldal
</route>
