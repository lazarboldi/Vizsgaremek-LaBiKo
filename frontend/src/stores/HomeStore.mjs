import { defineStore } from 'pinia'

const filters = [
  { id: 'brand', label: 'Márka szűrés' },
  { id: 'model', label: 'Modell szűrés' },
  { id: 'body', label: 'Kivitel szűrés' },
  { id: 'fuel', label: 'Üzemanyag szűrés' },
  { id: 'year', label: 'Évjárat szűrés' },
  { id: 'price', label: 'Vételár szűrés' }
]

const cars = [
  {
    id: 1,
    title: 'Minta leírás',
    description: 'Minta szöveg a főoldal kártyájához.'
  },
  {
    id: 2,
    title: 'Minta leírás',
    description: 'Minta szöveg a főoldal kártyájához.'
  },
  {
    id: 3,
    title: 'Minta leírás',
    description: 'Minta szöveg a főoldal kártyájához.'
  },
  {
    id: 4,
    title: 'Minta leírás',
    description: 'Minta szöveg a főoldal kártyájához.'
  }
]

export const useHomeStore = defineStore('home', {
  state: () => ({
    activeFilterId: 'brand',
    filters,
    cars
  })
})
