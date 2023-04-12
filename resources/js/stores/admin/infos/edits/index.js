
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
      date_available: null,
      sort_order: 0,
      status: 1,
      name: '',
      meta_title: '',
      sort_description: '',
      information_type: 1,
      description: '',
      tag: '',
      meta_description: '',
      meta_keyword: '',
      multi_images: [],
      relateds: [],
      categorys: [],
      downloads: [],
      special_carousels: [],
    },
    isImgChange: false,
    listCategorysDisplay: [],
    listRelatedsDisplay: [],
    albumDropdowns: [],
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

    getInfoField(state) {
      return getField(state.info)
    },
  },
  mutations: Mutations.MUTATIONS,
  actions: Actions.ACTIONS,
}
