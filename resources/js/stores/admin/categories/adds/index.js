const Actions = require('./actions');
const Mutations = require('./mutations');

const defaultState = () => {
  return {
    isOpen: false,
    action: null,
    classShow: 'modal fade',
    styleCss: '',
    newsGroupAdd: {
      category_id: null,
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
      nameQuery: '',
    },
    newsGroupId: 0,
    itemRoot: 0,
    loading: false,
    insertSuccess: false,
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
    nameQuery(state) {
      return state.newsGroupAdd.nameQuery
    },
    loading(state) {
      return state.loading
    },
    insertSuccess(state) {
      return state.insertSuccess
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
