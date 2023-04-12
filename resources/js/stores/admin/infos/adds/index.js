const Actions = require('./actions');
const Mutations = require('./mutations');
import { getField } from 'vuex-map-fields'

const defaultState = () => {
  return {
    isOpen: false,
    action: null,
    classShow: 'modal fade',
    styleCss: '',
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
      sort_order: 1,
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
      album: null,
    },
    isImgChange: true,
    listCategorysDisplay: [],
    listRelatedsDisplay: [],
    dropdownsRelateds: [],
    albumDropdowns: [],
    infoRelated: {
      information_id: 0,
      name: '',
    },
    infoId: 0,
    loading: false,
    insertSuccess: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    isOpen(state) {
      return state.isOpen
    },
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
    getInfoField(state) {
      return getField(state.info)
    },
  },
  mutations: Mutations.MUTATIONS,
  actions: Actions.ACTIONS,
}
