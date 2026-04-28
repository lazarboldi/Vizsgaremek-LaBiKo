import { describe, it, expect, beforeEach, vi } from 'vitest'
import { ref } from 'vue'
import { mount } from '@vue/test-utils'

import RegisterPage from '@/pages/auth/register.vue'

const mocks = vi.hoisted(() => ({
  authStore: null
}))

vi.mock('pinia', () => ({
  storeToRefs: (store) => store.__refs
}))

vi.mock('@stores/AuthStore.mjs', () => ({
  useAuthStore: () => mocks.authStore
}))

const createAuthStore = () => {
  const loading = ref(false)
  const errorMessage = ref('')
  const successMessage = ref('')
  const isAuthenticated = ref(false)
  const registerForm = ref({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: ''
  })

  return {
    register: vi.fn(async () => {}),
    __refs: {
      loading,
      errorMessage,
      successMessage,
      registerForm,
      isAuthenticated
    }
  }
}

const mountPage = () => mount(RegisterPage, {
  global: {
    stubs: {
      BaseLayout: { template: '<div><slot /></div>' },
      RouterLink: { template: '<a><slot /></a>' }
    }
  }
})

describe('Register page', () => {
  beforeEach(() => {
    mocks.authStore = createAuthStore()
  })

  it('shows validation error when required fields are missing', async () => {
    const wrapper = mountPage()

    await wrapper.get('form').trigger('submit.prevent')

    expect(mocks.authStore.register).not.toHaveBeenCalled()
    expect(mocks.authStore.__refs.errorMessage.value).toBe('Kérjük, töltse ki a kötelező mezőket.')
  })

  it('calls register action with valid form data', async () => {
    mocks.authStore.__refs.registerForm.value = {
      name: 'Teszt Elek',
      email: 'teszt.elek@example.com',
      phone: '+36701234567',
      password: 'StrongPass123',
      password_confirmation: 'StrongPass123'
    }

    const wrapper = mountPage()
    await wrapper.get('form').trigger('submit.prevent')

    expect(mocks.authStore.register).toHaveBeenCalledTimes(1)
  })

  it('shows logged-in state when user is already authenticated', () => {
    mocks.authStore.__refs.isAuthenticated.value = true

    const wrapper = mountPage()

    expect(wrapper.text()).toContain('Már be van jelentkezve.')
    expect(wrapper.find('form').exists()).toBe(false)
  })
})
