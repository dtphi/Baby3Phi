const Actions = require('./actions');
const Mutations = require('./mutations');

export default {
  namespaced: true,
  state: {
    mainMenus: [],
    pageLists: [],
    loading: false,
    errors: [],
  },
  getters: {
    mainMenus(state) {
      return state.mainMenus
    },
    pageLists(state) {
      return state.pageLists
    },
    loading(state) {
      return state.loading
    },
  },
  mutations: Mutations.MUTATIONS,
  actions: Actions.ACTIONS,
}
