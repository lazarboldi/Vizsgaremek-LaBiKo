import { describe, it, expect, beforeEach, vi } from 'vitest'
import { ref } from 'vue'
import { mount, flushPromises } from '@vue/test-utils'

import ListingDetailPage from '@/pages/Listing/[id].vue'

const mocks = vi.hoisted(() => ({
  route: {
    params: { id: '42' },
    fullPath: '/listing/42'
  },
  router: {
    push: vi.fn(),
    replace: vi.fn()
  },
  listingStore: null,
  authStore: null,
  favouritesStore: null,
  lightboxOption: vi.fn()
}))

vi.mock('pinia', () => ({
  storeToRefs: (store) => ({
    isAuthenticated: ref(Boolean(store.isAuthenticated))
  })
}))

vi.mock('lightbox2', () => ({
  default: {
    option: (...args) => mocks.lightboxOption(...args)
  }
}))

vi.mock('@stores/NewListingStore.mjs', () => ({
  useListing: () => mocks.listingStore
}))

vi.mock('@stores/AuthStore.mjs', () => ({
  useAuthStore: () => mocks.authStore
}))

vi.mock('@stores/FavouritesStore.mjs', () => ({
  useFavouritesStore: () => mocks.favouritesStore
}))

vi.mock('vue-router', async () => {
  const actual = await vi.importActual('vue-router')

  return {
    ...actual,
    useRoute: () => mocks.route,
    useRouter: () => mocks.router
  }
})

const sampleListing = {
  id: 42,
  price: 5200000,
  horsepower: 143,
  car: {
    brand: 'Toyota',
    model: 'Corolla',
    year: '2020',
    mileage: 85000,
    fuel_type: 'benzin',
    transmission: 'manual',
    engine_size: 1600,
    body_type: 'sedan',
    color: 'fekete',
    description: 'Megkimélt állapotú autó',
    images: [
      { image_url: 'https://example.com/car-1.jpg' }
    ]
  },
  user: {
    name: 'Teszt Eladó',
    email: 'elado@example.com',
    phone: '+36701234567'
  }
}

const mountPage = () => mount(ListingDetailPage, {
  global: {
    stubs: {
      BaseLayout: { template: '<div><slot /></div>' },
      RouterLink: { template: '<a><slot /></a>' }
    }
  }
})

describe('Listing detail page', () => {
  beforeEach(() => {
    mocks.route = {
      params: { id: '42' },
      fullPath: '/listing/42'
    }
    mocks.router.push.mockReset()
    mocks.router.replace.mockReset()
    mocks.lightboxOption.mockReset()

    mocks.listingStore = {
      getListingById: vi.fn(async () => sampleListing)
    }

    mocks.authStore = {
      isAuthenticated: true
    }

    mocks.favouritesStore = {
      loadFavourites: vi.fn(async () => {}),
      isFavourite: vi.fn(() => false),
      toggleFavourite: vi.fn(async () => true)
    }
  })

  it('loads and renders listing details', async () => {
    const wrapper = mountPage()
    await flushPromises()
    const normalizedText = wrapper.text().replace(/[\u00A0\u202F]/g, ' ')

    expect(mocks.listingStore.getListingById).toHaveBeenCalledWith('42')
    expect(normalizedText).toContain('Toyota Corolla')
    expect(normalizedText).toContain('5 200 000 Ft')
    expect(normalizedText).toContain('Teszt Eladó')
  })

  it('shows backend error when listing load fails', async () => {
    mocks.listingStore.getListingById = vi.fn(async () => {
      throw new Error('A hirdetés nem található.')
    })

    const wrapper = mountPage()
    await flushPromises()

    expect(wrapper.text()).toContain('A hirdetés nem található.')
  })

  it('redirects unauthenticated users to login on favourite click', async () => {
    mocks.authStore.isAuthenticated = false

    const wrapper = mountPage()
    await flushPromises()

    const favouriteButton = wrapper.findAll('button').find((btn) => btn.text().includes('gyűjtemény'))
    expect(favouriteButton).toBeTruthy()

    await favouriteButton.trigger('click')

    expect(mocks.router.push).toHaveBeenCalledWith('/auth/login?redirect=%2Flisting%2F42')
    expect(mocks.favouritesStore.toggleFavourite).not.toHaveBeenCalled()
  })
})