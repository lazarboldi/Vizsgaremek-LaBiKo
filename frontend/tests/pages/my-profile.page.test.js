import { describe, it, expect, beforeEach, vi } from 'vitest'
import { mount, flushPromises } from '@vue/test-utils'

import MyProfilePage from '@/pages/myprofile/my-profile.vue'

const mocks = vi.hoisted(() => ({
  authStore: null,
  listingStore: null,
  api: {
    get: vi.fn(),
    delete: vi.fn(),
    patch: vi.fn(),
    post: vi.fn()
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

const mountPage = () => mount(MyProfilePage, {
  global: {
    stubs: {
      BaseLayout: { template: '<div><slot /></div>' },
      BaseConfirmDialog: { template: '<div />' },
      RouterLink: { template: '<a><slot /></a>' }
    }
  }
})

describe('My profile page', () => {
  beforeEach(() => {
    mocks.authStore = {
      token: 'user-token',
      isAuthenticated: true
    }

    mocks.listingStore = {
      deleteListing: vi.fn(async () => {}),
      removeListingFromState: vi.fn()
    }

    mocks.api.get.mockReset()
    mocks.router.push.mockReset()
    mocks.router.replace.mockReset()
  })

  it('redirects guest users to login', async () => {
    mocks.authStore.isAuthenticated = false

    mountPage()
    await flushPromises()

    expect(mocks.router.replace).toHaveBeenCalledWith('/auth/login?redirect=/my-profile')
    expect(mocks.api.get).not.toHaveBeenCalled()
  })

  it('loads and renders user profile data for authenticated user', async () => {
    mocks.api.get.mockResolvedValue({
      data: {
        data: {
          user: {
            id: 5,
            name: 'Teszt Felhasználó',
            email: 'teszt@example.com',
            phone: '+36701112233',
            created_at: '2026-01-03T10:20:30.000000Z'
          },
          listings: [
            {
              id: 88,
              price: 4200000,
              car: {
                brand: 'Suzuki',
                model: 'Swift',
                images: []
              }
            }
          ]
        }
      }
    })

    const wrapper = mountPage()
    await flushPromises()

    expect(mocks.api.get).toHaveBeenCalledWith('users/me', {
      headers: { Authorization: 'Bearer user-token' }
    })
    expect(wrapper.text()).toContain('Profilom')
    expect(wrapper.text()).toContain('Teszt Felhasználó')
    expect(wrapper.text()).toContain('teszt@example.com')
    expect(wrapper.text()).toContain('Hirdetés ID: 88')
  })

  it('shows empty state when user has no own listings', async () => {
    mocks.api.get.mockResolvedValue({
      data: {
        data: {
          user: {
            id: 6,
            name: 'Másik User',
            email: 'masik@example.com'
          },
          listings: []
        }
      }
    })

    const wrapper = mountPage()
    await flushPromises()

    expect(wrapper.text()).toContain('Még nincs saját hirdetésed.')
  })
})