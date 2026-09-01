import api from './axios'
import type { AuthResponse, User } from './types'

export interface RegisterPayload {
    name: string
    email: string
    password: string
    password_confirmation: string
}

export interface LoginPayload {
    email: string
    password: string
}

export const register = (data: RegisterPayload) => {
    return api.post<AuthResponse>('/auth/register', data)
}

export const login = (data: LoginPayload) => {
    return api.post<AuthResponse>('/auth/login', data)
}

export const getMe = () => {
    return api.get<User>('/auth/me')
}

export const logout = () => {
    return api.post('/auth/logout')
}