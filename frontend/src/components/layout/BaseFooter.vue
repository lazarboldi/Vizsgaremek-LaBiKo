<script setup>
const currentYear = new Date().getFullYear()
</script>

<template>
  <footer class="px-4 pt-10 pb-3 md:px-6 md:pt-10 md:pb-4">
    <div class="mx-auto max-w-[1320px] rounded-2xl border border-white/15 bg-gradient-to-r from-slate-950/90 via-slate-900/90 to-blue-950/90 shadow-lg shadow-slate-950/40 backdrop-blur-xl">
      <div class="flex flex-col gap-2 px-4 py-4 text-sm md:flex-row md:items-center md:justify-between md:px-6 md:py-4">
        <p class="m-0 font-bold tracking-tight text-white">CarLink</p>
        <p class="m-0 text-slate-300">&copy; {{ currentYear }} Minden jog fenntartva.</p>
      </div>
    </div>
  </footer>
</template>
