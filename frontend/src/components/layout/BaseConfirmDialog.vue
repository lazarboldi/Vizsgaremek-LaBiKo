<script setup>
const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    default: 'Megerősítés'
  },
  message: {
    type: String,
    default: ''
  },
  confirmText: {
    type: String,
    default: 'Igen'
  },
  cancelText: {
    type: String,
    default: 'Mégse'
  }
})

const emit = defineEmits(['update:modelValue', 'confirm', 'cancel'])

const closeDialog = () => {
  emit('update:modelValue', false)
  emit('cancel')
}

const handleConfirm = () => {
  emit('confirm')
}

const handleBackdropClick = (event) => {
  if (event.target === event.currentTarget) {
    closeDialog()
  }
}
</script>


<template>
  <Teleport to="body">
    <div
      v-if="props.modelValue"
      class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 p-4"
      @click="handleBackdropClick"
    >
      <div
        class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-5 shadow-2xl"
        role="dialog"
        aria-modal="true"
      >
        <h3 class="m-0 text-lg font-extrabold text-slate-800">{{ props.title }}</h3>
        <p class="mt-2 mb-5 text-sm font-semibold text-slate-600">{{ props.message }}</p>
        <div class="flex justify-end gap-2">
          <button
            type="button"
            class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-bold text-slate-700 transition hover:border-slate-400"
            @click="closeDialog"
          >
            {{ props.cancelText }}
          </button>
          <button
            type="button"
            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-red-700"
            @click="handleConfirm"
          >
            {{ props.confirmText }}
          </button>
        </div>
      </div>
    </div>
  </Teleport>
</template>