import { describe, it, expect, beforeEach, vi } from 'vitest'
import { mount, flushPromises } from '@vue/test-utils'

import AdminListingsPage from '@/pages/admin/listings.vue'

const mocks = vi.hoisted(() => ({
  authStore: null,
  listingStore: null,
  api: {
    get: vi.fn(),
    delete: vi.fn(),
    patch: vi.fn()
  },
  router: {
    push: vi.fn(),
    replace: vi.fn()
  }
}))

vi.mock('vue-router', async () => {
  const actual = await vi.importActual('vue-router')

  return {
    ...actual,
    useRouter: () => mocks.router
  }
})

vi.mock('@stores/AuthStore.mjs', () => ({
  useAuthStore: () => mocks.authStore
}))

vi.mock('@stores/NewListingStore.mjs', () => ({
  useListing: () => mocks.listingStore
}))

vi.mock('@utils/http.mjs', () => ({
  api: mocks.api
}))

const mountPage = () => mount(AdminListingsPage, {
  global: {
    stubs: {
      BaseLayout: { template: '<div><slot /></div>' },
      BaseConfirmDialog: { template: '<div />' },
      RouterLink: { template: '<a><slot /></a>' }
    }
  }
})

describe('Admin listings page', () => {
  beforeEach(() => {
    mocks.authStore = {
      token: 'admin-token',
      isAuthenticated: true,
      isAdmin: true
    }
    mocks.listingStore = {
      removeListingFromState: vi.fn()
    }

    mocks.api.get.mockReset()
    mocks.api.delete.mockReset()
    mocks.api.patch.mockReset()
    mocks.router.push.mockReset()
    mocks.router.replace.mockReset()
  })

  it('redirects unauthenticated users to login page', async () => {
    mocks.authStore.isAuthenticated = false

    mountPage()
    await flushPromises()

    expect(mocks.router.replace).toHaveBeenCalledWith('/auth/login?redirect=/admin/listings')
    expect(mocks.api.get).not.toHaveBeenCalled()
  })

  it('redirects non-admin users to home', async () => {
    mocks.authStore.isAdmin = false

    mountPage()
    await flushPromises()

    expect(mocks.router.replace).toHaveBeenCalledWith('/')
    expect(mocks.api.get).not.toHaveBeenCalled()
  })

  it('loads and renders admin listings for admin users', async () => {
    mocks.api.get.mockResolvedValue({
      data: {
        data: [
          {
            id: 11,
            status: 'pending',
            price: 5400000,
            car: { brand: 'Toyota', model: 'Corolla' },
            user: { name: 'Admin Teszt', email: 'admin@example.com' }
          }
        ]
      }
    })

    const wrapper = mountPage()
    await flushPromises()

    expect(mocks.api.get).toHaveBeenCalledWith('admin/listings', {
      headers: { Authorization: 'Bearer admin-token' }
    })
    expect(wrapper.text()).toContain('Admin hirdetéskezelés')
    expect(wrapper.text()).toContain('Toyota Corolla')
    expect(wrapper.text()).toContain('Hirdetés ID: 11')
  })
})