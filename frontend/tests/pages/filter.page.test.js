import { describe, it, expect, beforeEach, vi } from 'vitest'
import { mount, flushPromises } from '@vue/test-utils'

import IndexPage from '@/pages/index.vue'

const mocks = vi.hoisted(() => ({
  listingStore: null,
  newListingStore: null,
  authStore: null,
  favouritesStore: null
}))

vi.mock('@stores/ListingStore.mjs', () => ({
  useListingStore: () => mocks.listingStore
}))

vi.mock('@stores/NewListingStore.mjs', () => ({
  useListing: () => mocks.newListingStore
}))

vi.mock('@stores/AuthStore.mjs', () => ({
  useAuthStore: () => mocks.authStore
}))

vi.mock('@stores/FavouritesStore.mjs', () => ({
  useFavouritesStore: () => mocks.favouritesStore
}))

const sampleListings = () => ([
  {
    id: 1,
    price: '4600000',
    horsepower: 140,
    car: {
      id: 101,
      brand: 'Toyota',
      model: 'Corolla',
      description: 'Toyota listing',
      year: '2018',
      fuel_type: 'benzin',
      body_type: 'sedan',
      mileage: '120000',
      transmission: 'manual',
      images: []
    }
  },
  {
    id: 2,
    price: '6200000',
    horsepower: 150,
    car: {
      id: 102,
      brand: 'Ford',
      model: 'Focus',
      description: 'Ford listing',
      year: '2021',
      fuel_type: 'diesel',
      body_type: 'wagon',
      mileage: '70000',
      transmission: 'automatic',
      images: []
    }
  },
  {
    id: 3,
    price: '3900000',
    horsepower: 100,
    car: {
      id: 103,
      brand: 'Suzuki',
      model: 'Swift',
      description: 'Suzuki listing',
      year: '2016',
      fuel_type: 'benzin',
      body_type: 'hatchback',
      mileage: '150000',
      transmission: 'manual',
      images: []
    }
  }
])

const mountPage = () => mount(IndexPage, {
  global: {
    stubs: {
      BaseLayout: { template: '<div><slot /></div>' },
      BaseCard: {
        props: ['car'],
        template: '<article data-test="car-card">{{ car.title }}</article>'
      }
    }
  }
})

const cardTitles = (wrapper) => wrapper.findAll('[data-test="car-card"]').map((node) => node.text())

describe('Home page filters', () => {
  beforeEach(() => {
    mocks.listingStore = {
      filters: [
        { id: 'brand', label: 'Márka szűrés' },
        { id: 'model', label: 'Modell szűrés' },
        { id: 'body', label: 'Kivitel szűrés' },
        { id: 'fuel', label: 'Üzemanyag szűrés' },
        { id: 'year', label: 'Évjárat szűrés' },
        { id: 'price', label: 'Vételár szűrés' }
      ]
    }
    mocks.newListingStore = {
      listings: sampleListings(),
      getListings: vi.fn(async () => {})
    }
    mocks.authStore = {
      isAuthenticated: false
    }
    mocks.favouritesStore = {
      loadFavourites: vi.fn(async () => {})
    }
  })

  it('filters results by selected brand', async () => {
    const wrapper = mountPage()
    await flushPromises()

    const brandSelect = wrapper.findAll('aside select')[0]
    await brandSelect.setValue('Toyota')

    expect(cardTitles(wrapper)).toEqual(['Toyota Corolla'])
  })

  it('applies max year filter correctly', async () => {
    const wrapper = mountPage()
    await flushPromises()

    await wrapper.get('input[placeholder="Pl.: 2018 (max)"]').setValue('2018')

    const titles = cardTitles(wrapper)
    expect(titles).toContain('Toyota Corolla')
    expect(titles).toContain('Suzuki Swift')
    expect(titles).not.toContain('Ford Focus')
  })

  it('resets all filters with reset button', async () => {
    const wrapper = mountPage()
    await flushPromises()

    const brandSelect = wrapper.findAll('aside select')[0]
    await brandSelect.setValue('Ford')
    expect(cardTitles(wrapper)).toEqual(['Ford Focus'])

    await wrapper.get('button').trigger('click')

    expect(cardTitles(wrapper)).toHaveLength(3)
  })
})
