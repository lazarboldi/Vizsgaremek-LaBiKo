<script setup>
import carBlueImage from '@assets/images/home/car-blue.jpg'

defineProps({
  car: {
    type: Object,
    required: true
  }
})
</script>

<template>
  <article
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md transition-transform duration-200 hover:-translate-y-1 hover:shadow-xl"
  >
    <div class="overflow-hidden">
      <img
        :src="carBlueImage"
        :alt="car.title"
        class="block h-[235px] w-full object-cover max-[640px]:h-[205px]"
        loading="lazy"
      />
    </div>

    <div class="px-5 pt-5 pb-5">
      <h3 class="m-0 text-[2rem] leading-tight font-extrabold text-slate-800 max-[640px]:text-[1.6rem]">
        {{ car.title }}
      </h3>
      <p class="mt-3 mb-0 max-w-[33ch] text-[1.1rem] leading-relaxed text-slate-500 max-[640px]:text-base">
        {{ car.description }}
      </p>
    </div>
  </article>
</template>
