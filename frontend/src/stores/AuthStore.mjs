import { defineStore } from 'pinia'
import { api } from '@utils/http.mjs'

const defaultLoginForm = () => ({
  email: '',
  password: ''
})

const defaultRegisterForm = () => ({
  name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: ''
})

const usernameFromFullName = (fullName = '') => {
  const firstName = fullName.trim().split(/\s+/)[0] ?? ''
  return firstName.toLowerCase()
}

export const useAuthStore = defineStore('auth', {
  state: () => ({
    loading: false,
    errorMessage: '',
    successMessage: '',
    token: null,
    userName: '',
    userRole: 'user',
    loginForm: defaultLoginForm(),
    registerForm: defaultRegisterForm()
  }),
  getters: {
    isAuthenticated(state) {
      return state.token !== null && state.token !== ''
    },
    isAdmin(state) {
      return state.userRole === 'admin'
    }
  },
  actions: {
    resetMessages() {
      this.errorMessage = ''
      this.successMessage = ''
    },
    async login() {
      this.loading = true
      this.resetMessages()

      try {
        const { data } = await api.post('login', this.loginForm)
        this.token = data?.data?.token ?? null
        const fullName = data?.data?.user?.name ?? ''
        this.userRole = data?.data?.user?.role ?? 'user'
        this.userName = usernameFromFullName(fullName)
        this.successMessage = 'Sikeres bejelentkezes.'
      } catch {
        this.userRole = 'user'
        this.errorMessage = 'Sikertelen bejelentkezes.'
      } finally {
        this.loading = false
      }
    },
    async register() {
      this.loading = true
      this.resetMessages()

      try {
        const { data } = await api.post('registration', this.registerForm)
        this.userName = usernameFromFullName(this.registerForm.name)
        this.successMessage = data?.message ?? 'Sikeres regisztracio.'
        this.registerForm = defaultRegisterForm()
      } catch {
        this.errorMessage = 'Sikertelen regisztracio.'
      } finally {
        this.loading = false
      }
    },
    logout() {
      this.token = null
      this.userName = ''
      this.userRole = 'user'
      this.errorMessage = ''
      this.successMessage = ''
      this.loginForm = defaultLoginForm()
    }
  }
})
