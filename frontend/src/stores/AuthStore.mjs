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

const translateAuthError = (message) => {
  const normalized = String(message || '').trim()

  switch (normalized) {
    case 'The phone field format is invalid.':
      return 'A telefonszám formátuma érvénytelen.'
    case 'The email field must be a valid email address.':
      return 'Az e-mail cím formátuma érvénytelen.'
    case 'The email field is required.':
      return 'Az e-mail cím megadása kötelező.'
    case 'The password field is required.':
      return 'A jelszó megadása kötelező.'
    case 'The password field must be at least 8 characters.':
      return 'A jelszónak legalább 8 karakter hosszúnak kell lennie.'
    case 'The password confirmation does not match.':
      return 'A jelszavak nem egyeznek.'
    case 'The password confirmation field confirmation does not match.':
      return 'A jelszavak nem egyeznek.'
    case 'The password field confirmation does not match.':
      return 'A jelszavak nem egyeznek.'
    case 'The email has already been taken.':
      return 'Ez az e-mail cím már foglalt.'
    default:
      return normalized
  }
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
  persist: {
    pick: ['token', 'userName', 'userRole']
  },
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
        this.successMessage = 'Sikeres bejelentkezés.'
      } catch (error) {
        this.userRole = 'user'

        const validationErrors = error.response?.data?.errors
        const firstValidationError = validationErrors
          ? translateAuthError(Object.values(validationErrors)[0]?.[0])
          : ''

        this.errorMessage = firstValidationError || 'Sikertelen bejelentkezés.'
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
        this.successMessage = data?.message ?? 'Sikeres regisztráció.'
        this.registerForm = defaultRegisterForm()
      } catch (error) {
        const validationErrors = error.response?.data?.errors
        const phoneError = validationErrors?.phone?.[0]
        const firstValidationError = validationErrors
          ? Object.values(validationErrors)[0]?.[0]
          : null

        this.errorMessage = translateAuthError(phoneError || firstValidationError) || 'Sikertelen regisztráció.'
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
