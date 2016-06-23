export function saveUser ({ dispatch }, user) {
    dispatch('LOGIN', user)
}

export function clearUser ({ dispatch }) {
    dispatch('LOGOUT')
}