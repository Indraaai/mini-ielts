import api from './axios'
import type {
    ApiResponse,
    SpeakingAttempt,
    SpeakingQuestion,
    SpeakingResult,
} from './types'

export interface SubmitSpeakingPayload {
    question_id: number
    answer: string
}

export interface SubmitSpeakingResponse {
    message: string
    data: {
        attempt: SpeakingAttempt
        result: SpeakingResult
    }
}

export const getQuestions = () => {
    return api.get<ApiResponse<SpeakingQuestion[]>>(
        '/speaking/questions'
    )
}

export const submitSpeaking = (
    data: SubmitSpeakingPayload
) => {
    return api.post<SubmitSpeakingResponse>(
        '/speaking/submit',
        data
    )
}

export const getAttempts = () => {
    return api.get<ApiResponse<SpeakingAttempt[]>>(
        '/speaking/attempts'
    )
}

export const getAttempt = (attemptId: number) => {
    return api.get<ApiResponse<SpeakingAttempt>>(
        `/speaking/attempts/${attemptId}`
    )
}