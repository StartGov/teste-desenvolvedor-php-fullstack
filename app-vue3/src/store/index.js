import { createStore } from 'vuex'

export default createStore({
  state: {
    response_messages: null
  },
  mutations: {
    setMessage(state, message) {
      state.response_messages = message
    },
    clearMessage(state) {
      state.response_messages = null
    }
  },
  actions: {
    setMessage({ commit }, message) {
      commit('setMessage', message)
    },
    clearMessage({ commit }) {
      commit('clearMessage')
    }
  },
  getters: {
    getMessage(state) {
      return state.response_messages
    }
  },
  modules: {}
})
