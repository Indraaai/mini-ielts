import { defineStore } from 'pinia'

import { getQuestions } from '@/api/speaking'

import type { SpeakingQuestion } from '@/api/types'

interface SpeakingState {
    questions: SpeakingQuestion[]
    loading: boolean
    error: string | null
}

export const useSpeakingStore = defineStore('speaking', {
    state: (): SpeakingState => ({
        questions: [],
        loading: false,
        error: null,
    }),

    actions: {
        async fetchQuestions() {
            this.loading = true
            this.error = null

            try {
                const response = await getQuestions()

                this.questions = response.data.data
            } catch {
                this.error = 'Failed to load speaking questions.'
            } finally {
                this.loading = false
            }
        },
    },
})