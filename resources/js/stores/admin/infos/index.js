import BaseCRUD from '../BaseCRUD'
import modals from './modal'
import adds from './adds'
import edits from './edits'
const Actions = require('./actions');
const Mutations = require('./mutations');
const bcrud = new BaseCRUD('informations', { table: 'informations' })

const defaultState = () => {
  return {
    infos: [],
    total: 0,
    infoDelete: null,
    isDelete: false,
    isList: false,
    module_special_info_ids: [],
    module_special_infos: [],
    moduleSpecialData: {
      code: 'module_special_info',
      keys: [
        {
          key: 'module_special_info_ids',
          value: [],
          serialize: true,
        }
      ],
    },
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
    modal: modals,
    add: adds,
    edit: edits,
  },
}
