const Actions = require('./actions');
const Mutations = require('./mutations');
import { config, } from '@app/api/admin/config'

const defaultState = () => {
  return {
    styleCss: '',
    isExistInfo: config.existStatus.checking,
    info: {
      image: {
        basename: '',
        dirname: '',
        extension: '',
        filename: '',
        path: '',
        size: 0,
        thumb: '', //url thumb
        timestamp: null,
        type: null,
      },
      sort_id: 0,
      status: 1,
      albums_name: '',
      group_images: [],
      group_albums_id: null,
      id: null,
    },
    isImgChange: false,
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
        (state.isExistInfo !== config.existStatus.checking)
        || (state.isExistInfo !== config.existStatus.exist)
      ) {
        return false
      }

      return true
    },
  },
  mutations: Mutations.MUTATIONS,
  actions: Actions.ACTIONS,
}
