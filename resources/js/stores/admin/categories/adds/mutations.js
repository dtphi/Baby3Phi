import {
  NEWSGROUPS_MODAL_SET_OPEN_MODAL,
  NEWSGROUPS_MODAL_SET_CLOSE_MODAL,
  NEWSGROUPS_MODAL_SET_IS_OPEN_MODAL,
  NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID,
  NEWSGROUPS_MODAL_SET_LOADING,
  NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS,
  NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_FAILED,
  SET_ERROR,
} from '../../types/mutation-types'

export const MUTATIONS = {
  [NEWSGROUPS_MODAL_SET_OPEN_MODAL](state, payload) {
    state.action = payload
    state.classShow = 'modal fade show'
    state.styleCss = 'display:block'
    state.insertSuccess = false
    state.newsGroupId = 0
  },

  [NEWSGROUPS_MODAL_SET_CLOSE_MODAL](state) {
    const initState = defaultState()

    Object.assign(state.newsGroupAdd, initState.newsGroupAdd)
    state.errors = []
  },

  [NEWSGROUPS_MODAL_SET_IS_OPEN_MODAL](state, payload) {
    state.isOpen = payload
  },

  [NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID](state, payload) {
    state.newsGroupId = payload
  },

  [NEWSGROUPS_MODAL_SET_LOADING](state, payload) {
    state.loading = payload
  },

  [NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS](state, payload) {
    state.insertSuccess = payload
  },

  [NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_FAILED](state, payload) {
    state.insertSuccess = payload
  },

  [SET_ERROR](state, payload) {
    state.errors = payload
  },
}
