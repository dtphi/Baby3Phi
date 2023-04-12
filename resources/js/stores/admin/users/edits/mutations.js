import {
  USERS_MODAL_SET_OPEN_MODAL,
  USERS_MODAL_SET_CLOSE_MODAL,
  USERS_MODAL_SET_IS_OPEN_MODAL,
  USERS_MODAL_SET_USER_ID,
  USERS_MODAL_SET_USER_ID_FAILED,
  USERS_MODAL_SET_USER,
  USERS_MODAL_SET_LOADING,
  USERS_MODAL_UPDATE_USER_SUCCESS,
  USERS_MODAL_UPDATE_USER_FAILED,
  USERS_MODAL_SET_ERROR,
} from '../../types/mutation-types'
import { unserialize, } from 'php-serialize'

export const GETTERS = {
  isOpen(state) {
    return state.isOpen
  },
  classShow(state) {
    return state.classShow
  },
  styleCss(state) {
    return state.styleCss
  },
  user(state) {
    return state.user
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
}

export const MUTATIONS = {
  [USERS_MODAL_SET_OPEN_MODAL](state, payload) {
    state.action = payload
    state.classShow = 'modal in'
    state.styleCss = 'display:block'
    state.updateSuccess = false
  },

  [USERS_MODAL_SET_CLOSE_MODAL](state) {
    state.action = 'closeModal'
    state.classShow = 'modal'
    state.styleCss = 'display:none'
    state.userId = 0
    state.user = null
    state.errors = []
  },

  [USERS_MODAL_SET_IS_OPEN_MODAL](state, payload) {
    state.isOpen = payload
  },

  [USERS_MODAL_SET_USER_ID](state, payload) {
    state.userId = payload
  },

  [USERS_MODAL_SET_USER_ID_FAILED](state, payload) {
    state.errors = payload
  },

  [USERS_MODAL_SET_USER](state, payload) {
    if (Object.keys(payload.ruleSelect).length) {
      payload.ruleSelect = unserialize(payload.ruleSelect)
    }
    state.user = payload
  },

  [USERS_MODAL_SET_LOADING](state, payload) {
    state.loading = payload
  },

  [USERS_MODAL_UPDATE_USER_SUCCESS](state, payload) {
    state.updateSuccess = payload
  },

  [USERS_MODAL_UPDATE_USER_FAILED](state, payload) {
    state.updateSuccess = payload
  },

  [USERS_MODAL_SET_ERROR](state, payload) {
    state.errors = payload
  },
}
