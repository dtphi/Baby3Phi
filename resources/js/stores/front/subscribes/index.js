const Actions = require('./actions');
const Mutations = require('./mutations');

export default {
  namespaced: true,
  state: {
    subscribe: {
      email: '',
    },
    loading: false,
    errors: [],
    insertSuccess: false,
  },
  getters: {
    subscribe(state) {
      return state.subscribe
    },
    loading(state) {
      return state.loading
    },
    insertSuccess(state) {
      return state.insertSuccess
    },
  },
  mutations: Mutations.MUTATIONS,
  actions: Actions.ACTIONS,
}
