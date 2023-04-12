import {
  NEWSGROUPS_MODAL_SET_OPEN_MODAL,
  NEWSGROUPS_MODAL_SET_CLOSE_MODAL,
  NEWSGROUPS_MODAL_SET_IS_OPEN_MODAL,
  NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID,
  NEWSGROUPS_MODAL_SET_NEWS_GROUP,
  NEWSGROUPS_MODAL_SET_LOADING,
  NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS,
  NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_SUCCESS,
  NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_FAILED,
  NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_FAILED,
  SET_ERROR,
  SELECT_DROPDOWN_PARENT_CATEGORY,
  SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY,
} from '../../types/mutation-types'

export const MUTATIONS = {
  [NEWSGROUPS_MODAL_SET_OPEN_MODAL](state, payload) {
    state.action = payload
    state.classShow = 'modal fade show'
    state.styleCss = 'display:block'
    state.updateSuccess = false
  },

  [NEWSGROUPS_MODAL_SET_CLOSE_MODAL](state) {
    state.action = 'closeModal'
    state.classShow = 'modal fade'
    state.styleCss = 'display:none'
    state.errors = []
  },

  [NEWSGROUPS_MODAL_SET_IS_OPEN_MODAL](state, payload) {
    state.isOpen = payload
  },

  [NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID](state, payload) {
    state.newsGroupId = payload
  },

  [NEWSGROUPS_MODAL_SET_NEWS_GROUP](state, payload) {
    state.newsGroup = payload
  },

  [NEWSGROUPS_MODAL_SET_LOADING](state, payload) {
    state.loading = payload
  },

  [NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS](state, payload) {
    state.updateSuccess = payload
  },

  [NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_FAILED](state, payload) {
    state.updateSuccess = payload
  },

  [NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_SUCCESS](state, payload) {
    state.updateSuccess = payload
  },

  [NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_FAILED](state, payload) {
    state.updateSuccess = payload
  },

  [SET_ERROR](state, payload) {
    state.errors = payload
  },
  [SELECT_DROPDOWN_PARENT_CATEGORY](state, payload) {
    if (parseInt(payload.category_id) !== parseInt(state.newsGroupId)) {
      state.nameQuery = payload.name
      state.newsGroup.parent_id = payload.category_id
    }
  },
  [SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY](state, payload) {
    state.nameQuery = payload.name
    state.infoCategory = payload
  },
}
