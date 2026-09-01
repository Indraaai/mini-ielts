import { createRouter, createWebHistory } from 'vue-router'

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
            path: '/speaking',
            name: 'speaking',
            component: () => import('@/views/SpeakingView.vue'),
            meta: {
                requiresAuth: true,
            },
        },

        {
            path: '/history',
            name: 'history',
            component: () => import('@/views/HistoryView.vue'),
            meta: {
                requiresAuth: true,
            },
        },

        {
            path: '/result/:attemptId',
            name: 'result',
            component: () => import('@/views/ResultView.vue'),
            meta: {
                requiresAuth: true,
            },
        },

        {
            path: '/',
            redirect: '/speaking',
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