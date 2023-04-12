import BaseCRUD from '../BaseCRUD'
import adds from './adds'
import edits from './edits'
const Actions = require('./actions');
const Mutations = require('./mutations');
const bcrud = new BaseCRUD('restrict_ips', { table: 'restrict_ips' })

const defaultState = () => {
  return {
    infos: [],
    total: 0,
    isDelete: false,
    isList: false,
    loading: false,
    updateSuccess: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    infos(state) {
      return state.infos
    },
    loading(state) {
      return state.loading
    },
    errors(state) {
      return state.errors
    },
    isError(state) {
      return state.errors.length
    },
  },
  mutations: { ...Mutations.MUTATIONS, ...bcrud.mutations },
  actions: { ...Actions.ACTIONS, ...bcrud.actions },
  modules: {
    add: adds,
    edit: edits,
  },
}
