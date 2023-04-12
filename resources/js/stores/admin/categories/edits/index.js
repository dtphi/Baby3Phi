const Actions = require('./actions');
const Mutations = require('./mutations');

const defaultState = () => {
  return {
    isOpen: false,
    action: null,
    classShow: 'modal fade',
    styleCss: '',
    newsGroup: {
      category_id: null,
      category_name: '',
      name: '',
      tag: '',
      parent_id: 0,
      description: '',
      meta_title: '',
      meta_description: '',
      meta_keyword: '',
      sort_order: 0,
      status: 1,
      layout_id: null,
      path: null,
    },
    infoCategory: {
      category_name: '',
      category_id: null,
    },
    nameQuery: '',
    newsGroupId: 0,
    itemRoot: 0,
    loading: false,
    updateSuccess: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    newsGroupAdd(state) {
      return state.newsGroupAdd
    },
    isOpen(state) {
      return state.isOpen
    },
    action(state) {
      return state.action
    },
    classShow(state) {
      return state.classShow
    },
    styleCss(state) {
      return state.styleCss
    },
    newsGroup(state) {
      return state.newsGroup
    },
    infoCategory(state) {
      return state.infoCategory
    },
    getNameQuery(state) {
      var str = state.nameQuery

      if (typeof str === 'undefined' || str === null) {
        return ''
      }

      return str
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
  },
  mutations: Mutations.MUTATIONS,
  actions: Actions.ACTIONS,
}
