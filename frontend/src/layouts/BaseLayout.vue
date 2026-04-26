<script setup>
import BaseFooter from '@components/layout/BaseFooter.vue';
import BaseHeader from '@components/layout/BaseHeader.vue'
</script>

<template>
  <div class="bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200">
    <BaseHeader />
    <main class="container mx-auto">
      <slot />
    </main>
    <BaseFooter />
  </div>
</template>
