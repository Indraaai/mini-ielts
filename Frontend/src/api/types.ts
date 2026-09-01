export interface User {
    id: number
    name: string
    email: string
}

export interface AuthResponse {
    message: string
    user: User
    token: string
}

export interface SpeakingQuestion {
    id: number
    part: string
    topic: string
    prompt: string
}

export interface SpeakingResult {
    id: number
    attempt_id: number
    estimated_band: number
    strengths: string[]
    areas_to_improve: string[]
    feedback: string
}

export interface SpeakingAttempt {
    id: number
    question: SpeakingQuestion
    answer: string
    submitted_at: string
    result?: SpeakingResult | null
}

export interface ApiResponse<T> {
    data: T
}