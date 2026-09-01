import { createRouter, createWebHistory } from 'vue-router'

import AuthenticatedLayout from '@/components/layouts/AuthenticatedLayout.vue'

const router = createRouter({
    history: createWebHistory(),

    routes: [
        {
            path: '/login',
            name: 'login',
            component: () => import('@/views/LoginView.vue'),
            meta: {
                requiresGuest: true,
            },
        },

        {
            path: '/',
            component: AuthenticatedLayout,
            meta: {
                requiresAuth: true,
            },
            children: [
                {
                    path: 'speaking',
                    name: 'speaking',
                    component: () => import('@/views/SpeakingView.vue'),
                },

                {
                    path: 'history',
                    name: 'history',
                    component: () => import('@/views/HistoryView.vue'),
                },

                {
                    path: 'result/:attemptId',
                    name: 'result',
                    component: () => import('@/views/ResultView.vue'),
                },
            ],
        },
    ],
})

router.beforeEach((to) => {
    const token = localStorage.getItem('token')

    if (to.meta.requiresAuth && !token) {
        return {
            name: 'login',
        }
    }

    if (to.meta.requiresGuest && token) {
        return {
            name: 'speaking',
        }
    }

    return true
})

export default router