<script setup>
import BaseFooter from '@components/layout/BaseFooter.vue';
import BaseHeader from '@components/layout/BaseHeader.vue'
</script>

<template>
    <BaseHeader />
    <main class="flex-1 grid container mx-auto">
      <slot />
    </main>
    <BaseFooter />
</template>
