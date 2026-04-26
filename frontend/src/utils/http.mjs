import axios from 'axios'

const backendUrl = String(import.meta.env.VITE_BACKEND_URL || '').replace(/\/+$/, '')

export const api = axios.create({
    baseURL: backendUrl ? `${backendUrl}/api` : '/api',
    headers:{
        "Accept": "application/json"
    }
})
