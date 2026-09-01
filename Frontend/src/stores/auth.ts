import { defineStore } from 'pinia'
import { getMe, login, logout } from '@/api/auth'
import type { LoginPayload } from '@/api/auth'
import type { User } from '@/api/types'

interface AuthState {
    user: User | null
    token: string | null
    loading: boolean
}

export const useAuthStore = defineStore('auth', {
    state: (): AuthState => ({
        user: null,
        token: localStorage.getItem('token'),
        loading: false,
    }),

    getters: {
        isAuthenticated: (state): boolean => {
            return !!state.token
        },
    },

    actions: {
        async loginUser(data: LoginPayload) {
            this.loading = true

            try {
                const response = await login(data)

                const { token, user } = response.data

                this.token = token
                this.user = user

                localStorage.setItem('token', token)

                return response.data
            } finally {
                this.loading = false
            }
        },

        async fetchUser() {
            if (!this.token) {
                return
            }

            try {
                const response = await getMe()

                this.user = response.data
            } catch (error) {
                this.clearAuth()
                throw error
            }
        },
        async initializeAuth() {
            if (!this.token) {
                return
            }

            this.loading = true

            try {
                await this.fetchUser()
            } catch {
                this.clearAuth()
            } finally {
                this.loading = false
            }
        },

        async logoutUser() {
            try {
                if (this.token) {
                    await logout()
                }
            } finally {
                this.clearAuth()
            }
        },

        clearAuth() {
            this.user = null
            this.token = null

            localStorage.removeItem('token')
        },
    },
})