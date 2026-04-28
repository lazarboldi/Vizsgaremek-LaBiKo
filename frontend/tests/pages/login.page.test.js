import { describe, it, expect, beforeEach, vi } from 'vitest'
import { ref } from 'vue'
import { mount, flushPromises } from '@vue/test-utils'

import LoginPage from '@/pages/auth/login.vue'

const mocks = vi.hoisted(() => ({
  authStore: null,
  route: { query: {} },
  router: {
    push: vi.fn(),
    replace: vi.fn()
  }
}))

vi.mock('pinia', () => ({
  storeToRefs: (store) => store.__refs
}))

vi.mock('@stores/AuthStore.mjs', () => ({
  useAuthStore: () => mocks.authStore
}))

vi.mock('vue-router', async () => {
  const actual = await vi.importActual('vue-router')

  return {
    ...actual,
    useRoute: () => mocks.route,
    useRouter: () => mocks.router
  }
})

const createAuthStore = () => {
  const loading = ref(false)
  const errorMessage = ref('')
  const successMessage = ref('')
  const loginForm = ref({
    email: '',
    password: ''
  })
  const isAuthenticated = ref(false)

  const store = {
    loading,
    errorMessage,
    successMessage,
    loginForm,
    isAuthenticated: false,
    resetMessages: vi.fn(() => {
      errorMessage.value = ''
      successMessage.value = ''
    }),
    login: vi.fn(async () => {}),
    __refs: {
      loading,
      errorMessage,
      successMessage,
      loginForm,
      isAuthenticated
    }
  }

  Object.defineProperty(store, 'isAuthenticated', {
    get() {
      return isAuthenticated.value
    },
    set(value) {
      isAuthenticated.value = Boolean(value)
    }
  })

  return store
}

const mountPage = () => mount(LoginPage, {
  global: {
    stubs: {
      BaseLayout: { template: '<div><slot /></div>' },
      RouterLink: { template: '<a><slot /></a>' }
    }
  }
})

describe('Login page', () => {
  beforeEach(() => {
    mocks.authStore = createAuthStore()
    mocks.route = { query: {} }
    mocks.router.push.mockReset()
    mocks.router.replace.mockReset()
  })

  it('shows validation error for missing required fields', async () => {
    const wrapper = mountPage()

    await wrapper.get('form').trigger('submit.prevent')

    expect(mocks.authStore.login).not.toHaveBeenCalled()
    expect(mocks.authStore.__refs.errorMessage.value).toBe('Kérjük, töltse ki a kötelező mezőket.')
  })

  it('redirects to safe relative route after successful login', async () => {
    mocks.route = { query: { redirect: '/my-profile' } }
    mocks.authStore.__refs.loginForm.value = {
      email: 'teszt@example.com',
      password: 'StrongPass123'
    }
    mocks.authStore.login = vi.fn(async () => {
      mocks.authStore.isAuthenticated = true
    })

    const wrapper = mountPage()
    await wrapper.get('form').trigger('submit.prevent')
    await flushPromises()

    expect(mocks.authStore.login).toHaveBeenCalledTimes(1)
    expect(mocks.router.push).toHaveBeenCalledWith('/my-profile')
  })

  it('falls back to home route when redirect target is unsafe', async () => {
    mocks.route = { query: { redirect: 'https://malicious.example' } }
    mocks.authStore.__refs.loginForm.value = {
      email: 'teszt@example.com',
      password: 'StrongPass123'
    }
    mocks.authStore.login = vi.fn(async () => {
      mocks.authStore.isAuthenticated = true
    })

    const wrapper = mountPage()
    await wrapper.get('form').trigger('submit.prevent')
    await flushPromises()

    expect(mocks.router.push).toHaveBeenCalledWith('/')
  })
})
