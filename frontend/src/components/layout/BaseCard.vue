<script setup>
import carBlueImage from '@assets/images/home/car-blue.jpg'

const props = defineProps({
  car: {
    type: Object,
    required: true
  }
})

const backendOrigin = import.meta.env.VITE_BACKEND_URL?.replace(/\/api\/?$/, '/')

const resolveImageUrl = (url) => {
  if (!url || typeof url !== 'string') {
    return carBlueImage
  }

  const normalized = url.trim()

  if (!normalized) {
    return carBlueImage
  }

  if (/^https?:\/\//i.test(normalized)) {
    return normalized
  }

  if (!backendOrigin) {
    return normalized
  }

  return new URL(normalized, backendOrigin).toString()
}
</script>

<template>
  <RouterLink
    v-if="props.car.listingId"
    :to="`/listing/${props.car.listingId}`"
    class="block overflow-hidden rounded-2xl border border-slate-200 bg-white text-inherit no-underline shadow-md transition-transform duration-200 hover:-translate-y-1 hover:shadow-xl"
  >
    <article>
      <div class="overflow-hidden">
        <img
          :src="resolveImageUrl(props.car.image_url)"
          :alt="props.car.title"
          class="block h-[235px] w-full object-cover max-[640px]:h-[205px]"
          loading="lazy"
        />
      </div>

      <div class="px-5 pt-5 pb-5">
        <h3 class="m-0 text-[2rem] leading-tight font-extrabold text-slate-800 max-[640px]:text-[1.6rem]">
          {{ props.car.title }}
        </h3>
        <p class="mt-3 mb-0 max-w-[33ch] text-[1.1rem] leading-relaxed text-slate-500 max-[640px]:text-base">
          {{ props.car.description }}
        </p>
      </div>
    </article>
  </RouterLink>

  <article
    v-else
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md transition-transform duration-200 hover:-translate-y-1 hover:shadow-xl"
  >
    <div class="overflow-hidden">
      <img
        :src="resolveImageUrl(props.car.image_url)"
        :alt="props.car.title"
        class="block h-[235px] w-full object-cover max-[640px]:h-[205px]"
        loading="lazy"
      />
    </div>

    <div class="px-5 pt-5 pb-5">
      <h3 class="m-0 text-[2rem] leading-tight font-extrabold text-slate-800 max-[640px]:text-[1.6rem]">
        {{ props.car.title }}
      </h3>
      <p class="mt-3 mb-0 max-w-[33ch] text-[1.1rem] leading-relaxed text-slate-500 max-[640px]:text-base">
        {{ props.car.description }}
      </p>
    </div>
  </article>
</template>
