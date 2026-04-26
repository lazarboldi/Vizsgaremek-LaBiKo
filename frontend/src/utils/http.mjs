import axios from 'axios'

const backendUrl = String(import.meta.env.VITE_BACKEND_URL || '').replace(/\/+$/, '')
const backendHostUrl = backendUrl.replace(/\/api$/i, '')

export const api = axios.create({
    baseURL: backendHostUrl ? `${backendHostUrl}/api` : '/api',
    headers:{
        "Accept": "application/json"
    }
})
