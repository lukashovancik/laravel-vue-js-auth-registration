import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

const state = {
    user: {
        data: null,
        token:null,
        authenticated: false
    }
}

const mutations = {
    LOGIN (state,user) {
        state.user.data = user,
        state.user.token = localStorage.getItem('jwt-token'),
        state.user.authenticated = true
    },

    LOGOUT(state) {
        state.user.data = null,
        state.user.token = null,
        state.user.authenticated = false
    }
}

export default new Vuex.Store({
    state,
    mutations
})