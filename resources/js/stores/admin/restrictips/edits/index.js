
import { config, } from '@app/api/admin/config'
const Actions = require('./actions');
const Mutations = require('./mutations');

const defaultState = () => {
  return {
    isExistInfo: config.existStatus.checking,
    info: {
      ip: null,
      active: 1,
      updateUser: 1,
    },
    infoId: 0,
    loading: false,
    updateSuccess: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    info(state) {
      return state.info
    },
    loading(state) {
      return state.loading
    },
    updateSuccess(state) {
      return state.updateSuccess
    },
    errors(state) {
      return state.errors
    },
    isError(state) {
      return state.errors.length
    },
    isNotExistValidate(state) {
      if (
        state.isExistInfo !== config.existStatus.checking ||
        state.isExistInfo !== config.existStatus.exist
      ) {
        return false
      }

      return true
    },
  },
  mutations: Mutations.MUTATIONS,
  actions: Actions.ACTIONS,
}
