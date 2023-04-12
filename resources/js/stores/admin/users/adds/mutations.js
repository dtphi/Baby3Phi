import {
  USERS_MODAL_SET_OPEN_MODAL,
  USERS_MODAL_SET_CLOSE_MODAL,
  USERS_MODAL_SET_IS_OPEN_MODAL,
  USERS_MODAL_SET_LOADING,
  USERS_MODAL_INSERT_USER_SUCCESS,
  USERS_MODAL_UPDATE_USER_SUCCESS,
  USERS_MODAL_INSERT_USER_FAILED,
  USERS_MODAL_SET_ERROR,
} from '../../types/mutation-types'
import { defaultState } from '../../../../models/admins/users'

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
  insertSuccess(state) {
    return state.insertSuccess
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
    state.styleCss = 'display:block;'
    state.insertSuccess = ''
  },

  [USERS_MODAL_SET_CLOSE_MODAL](state) {
    state.action = 'closeModal'
    state.classShow = 'modal'
    state.styleCss = 'display:none;'
    state.userId = 0
    state.errors = []

    const initState = defaultState
    Object.assign(state.user, initState.user)
  },

  [USERS_MODAL_SET_IS_OPEN_MODAL](state, payload) {
    state.isOpen = payload
  },

  [USERS_MODAL_SET_LOADING](state, payload) {
    state.loading = payload
  },

  [USERS_MODAL_INSERT_USER_SUCCESS](state, payload) {
    state.insertSuccess = payload
  },

  [USERS_MODAL_INSERT_USER_FAILED](state, payload) {
    state.insertSuccess = payload
  },

  [USERS_MODAL_UPDATE_USER_SUCCESS](state, payload) {
    state.insertSuccess = payload
  },

  [USERS_MODAL_SET_ERROR](state, payload) {
    state.errors = payload
  },
}
