export function getUser(state) {
    return state.user.data
}

export function getToken (state) {
    return state.user.token
}

export function getAuthenticated (state) {
    return state.user.authenticated
}